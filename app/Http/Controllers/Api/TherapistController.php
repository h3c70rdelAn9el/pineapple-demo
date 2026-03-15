<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendTherapistInvoiceRequest;
use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\FileUpload;
use App\Models\TherapySession;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TherapistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $allTherapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->get();

        $therapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(30, ['*'], 'all_therapists');

        $activeTherapists = User::where('admin', 0)->where('active_status', 1)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(30, ['*'], 'active_therapists');

        $inactiveTherapists = User::where('admin', 0)->where('active_status', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(30, ['*'], 'inactive_therapists');

        // Incomplete therapists
        $incompleteData = $allTherapists->filter(fn (User $t) => !$t->isComplete()['status'] && !$t->isAdmin());
        $incompleteTherapists = $this->paginateCollection($incompleteData, $request, 'incomplete_therapists');

        // Unverified therapists
        $unverifiedData = $allTherapists->filter(fn (User $t) => !$t->isVerified()['status'] && !$t->isAdmin());
        $unverifiedTherapists = $this->paginateCollection($unverifiedData, $request, 'unverified_therapists');

        // Complete therapists
        $completeData = $allTherapists->filter(fn (User $t) => $t->isComplete()['status'] && !$t->isAdmin());
        $completeTherapists = $this->paginateCollection($completeData, $request, 'complete_therapists');

        // Flag filtering
        $flagFilteredTherapists = collect();
        $selectedFlag = $request->get('flag_filter');
        if ($selectedFlag) {
            $flagData = $allTherapists->filter(function (User $t) use ($selectedFlag) {
                $value = $t->{$selectedFlag};
                if (in_array($selectedFlag, ['out_of_state_coaching'])) {
                    return $value == 1 || $value === '1';
                }

                return (bool) $value === true;
            });
            $flagFilteredTherapists = $this->paginateCollection($flagData, $request, 'flag_therapists', ['flag_filter' => $selectedFlag]);
        }

        return response()->json([
            'therapists' => $therapists,
            'activeTherapists' => $activeTherapists,
            'inactiveTherapists' => $inactiveTherapists,
            'incompleteTherapists' => $incompleteTherapists,
            'unverifiedTherapists' => $unverifiedTherapists,
            'completeTherapists' => $completeTherapists,
            'flagFilteredTherapists' => $flagFilteredTherapists,
            'selectedFlag' => $selectedFlag,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $therapist = User::findOrFail($id);
        $clients = $therapist->clients()->get();
        $therapySessions = TherapySession::where('user_id', $therapist->id)->get();

        $totalSessionCost = number_format($therapist->sum('session_cost'), 2, '.', '');
        $totalClientContribution = number_format($clients->sum('client_contribution'), 2, '.', '');
        $total = number_format($totalSessionCost - $totalClientContribution, 2, '.', '');
        $totalClients = $clients->count();
        $spaceForNewClients = (int) $therapist->number_of_potential_clients - $totalClients;

        return response()->json([
            'therapist' => $therapist,
            'clients' => $clients,
            'therapySessions' => $therapySessions,
            'totalSessionCost' => $totalSessionCost,
            'totalClientContribution' => $totalClientContribution,
            'total' => $total,
            'spaceForNewClients' => $spaceForNewClients,
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        if (!auth()->user()?->admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $therapist = User::findOrFail($id);
        $genders = ['Male', 'Female', 'Transgender', 'Genderqueer', 'Genderfluid', 'Agender', 'Bigender', 'Cisgender', 'Non-Binary', 'Prefer Not To Say'];

        return response()->json([
            'therapist' => $therapist,
            'genders' => $genders,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $selectedGenders = $request->input('gender');
        $otherGender = $request->input('otherGender');
        $genderString = is_array($selectedGenders)
            ? (in_array('Other', $selectedGenders) && $otherGender
                ? implode(', ', array_map(fn ($v) => $v == 'Other' ? $otherGender : $v, $selectedGenders))
                : implode(', ', $selectedGenders))
            : $selectedGenders;

        $maxSessionCost = $user->admin == 1 ? 500 : 100;

        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'intern' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'county_town' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code_postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'routing_number' => 'nullable|string|max:255',
            'iban_swift_code' => 'nullable|string|max:255',
            'client_spaces' => 'nullable|string|max:255',
            'full' => 'nullable|boolean',
            'out_of_state_coaching' => 'nullable|boolean',
            'contact_for_promotionals' => 'nullable|boolean',
            'active_status' => 'nullable|boolean',
            'contract_signed' => 'nullable|boolean',
            'all_documents' => 'nullable|string|max:255',
            'website' => 'nullable|boolean',
            'quickbooks' => 'nullable|string|max:255',
            'session_cost' => 'nullable|numeric|max:' . $maxSessionCost,
            'notes' => 'nullable|string|max:255',
            'number_of_potential_clients' => 'nullable|numeric',
            'currency' => 'nullable|string|max:255',
            'client_extensions' => 'nullable|numeric',
            'invoice_payee' => 'nullable|string|max:255',
            'invoice_email' => 'nullable|email|max:255',
        ]);

        $therapist = User::findOrFail($id);
        $validatedData['gender'] = $genderString;

        if (empty($validatedData['invoice_payee'])) {
            $validatedData['invoice_payee'] = $therapist->name;
        }

        $addressFieldsChanged = $this->hasAddressChanged($therapist, $validatedData);
        $therapist->update($validatedData);

        if ($addressFieldsChanged && !$therapist->isAdmin()) {
            Mail::to($therapist->email)->send(new TherapistAddressUpdatedW9Reminder($therapist));
        }

        return response()->json(['message' => 'Profile updated!', 'therapist' => $therapist->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        $therapist = User::findOrFail($id);
        $therapist->delete();

        return response()->json(['message' => 'Therapist deleted successfully.']);
    }

    public function sendInvoice(SendTherapistInvoiceRequest $request, int $id): JsonResponse
    {
        $user = $request->user();
        $therapist = User::findOrFail($id);

        $now = Carbon::now();
        $month = $request->input('month');
        $sendingSpecificMonth = !empty($month);

        if ($sendingSpecificMonth) {
            $invoiceMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $start = $invoiceMonth->copy()->startOfMonth();
            $end = $invoiceMonth->copy()->endOfMonth();
            $periodLabel = $invoiceMonth->format('F Y');
        } else {
            $start = $now->copy()->subMonth()->startOfMonth();
            $end = $now->copy()->subMonth()->endOfMonth();
            $invoiceMonth = $start->copy();
            $periodLabel = "last month's";
        }

        $sessions = TherapySession::with('client')
            ->where('user_id', $therapist->id)
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at')
            ->get();

        if ($sessions->isEmpty()) {
            return response()->json(['message' => "No sessions found for {$periodLabel}."], 422);
        }

        $invoiceNumber = 'INV-' . $therapist->id . '-' . $invoiceMonth->format('Ym');
        $invoiceDate = $now->format('Y-m-d');
        $currencySymbol = $this->getCurrencySymbol($therapist->currency);

        $pdf = Pdf::loadView('invoices.therapist', [
            'therapist' => $therapist,
            'sessions' => $sessions,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'period' => [$start->format('Y-m-d'), $end->format('Y-m-d')],
            'currencySymbol' => $currencySymbol,
            'invoicePayee' => $therapist->invoice_payee ?? $therapist->name,
        ]);

        $filename = 'Invoice_' . $therapist->id . '_' . $invoiceMonth->format('Ym') . '.pdf';
        $adminEmail = $user->email;

        Mail::send('emails.therapist_invoice', [
            'therapist' => $therapist,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
        ], function ($message) use ($pdf, $filename, $adminEmail, $sendingSpecificMonth, $periodLabel) {
            $subject = $sendingSpecificMonth ? "Therapist Invoice - {$periodLabel}" : 'Therapist Invoice - Last Month';
            $message->to($adminEmail)->subject($subject)->attachData($pdf->output(), $filename);
        });

        return response()->json(['message' => "Invoice sent to {$adminEmail}."]);
    }

    private function paginateCollection($collection, Request $request, string $pageName, array $extraQuery = []): LengthAwarePaginator
    {
        $currentPage = $request->get($pageName, 1);
        $perPage = 30;
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'pageName' => $pageName, 'query' => $extraQuery]
        );
    }

    private function hasAddressChanged(User $user, array $data): bool
    {
        $addressFields = ['street_address', 'county_town', 'state', 'zip_code_postal_code', 'country'];
        foreach ($addressFields as $field) {
            if (isset($data[$field]) && $user->{$field} !== $data[$field]) {
                return true;
            }
        }

        return false;
    }

    private function getCurrencySymbol(?string $currency): string
    {
        return match ($currency) {
            'GBP' => '£',
            'EUR' => '€',
            default => '$',
        };
    }
}
