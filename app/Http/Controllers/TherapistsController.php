<?php

namespace App\Http\Controllers;

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\FileUpload;
use App\Models\TherapySession;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TherapistsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get all therapists for filtering
        $alltherapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->get();

        // Paginated results with different pagination parameters
        $therapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(30, ['*'], 'all_therapists');

        $activeTherapists = User::where('admin', 0)
            ->where('active_status', 1)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(30, ['*'], 'active_therapists');

        $inactiveTherapists = User::where('admin', 0)
            ->where('active_status', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(30, ['*'], 'inactive_therapists');

        // Filter incomplete therapists from all therapists
        $incompleteTherapists = collect();
        if ($alltherapists) {
            $incompleteTherapistsData = $alltherapists->filter(function (User $therapist) {
                $res = $therapist->isComplete();
                $incomplete = ! $res['status'];

                return $incomplete && ! $therapist->isAdmin();
            });

            // Convert to paginated collection
            $currentPage = request()->get('incomplete_therapists', 1);
            $perPage = 30;
            $currentPageItems = $incompleteTherapistsData->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $incompleteTherapists = new LengthAwarePaginator(
                $currentPageItems,
                $incompleteTherapistsData->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'pageName' => 'incomplete_therapists']
            );
        }

        // Filter unverified therapists from all therapists
        $unverifiedTherapists = collect();
        if ($alltherapists) {
            $unverifiedTherapistsData = $alltherapists->filter(function (User $therapist) {
                $unverified = ! $therapist->isVerified()['status'];

                return $unverified && ! $therapist->isAdmin();
            });

            // Convert to paginated collection
            $currentPage = request()->get('unverified_therapists', 1);
            $perPage = 30;
            $currentPageItems = $unverifiedTherapistsData->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $unverifiedTherapists = new LengthAwarePaginator(
                $currentPageItems,
                $unverifiedTherapistsData->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'pageName' => 'unverified_therapists']
            );
        }

        return view('therapist.index')->with([
            'therapists' => $therapists,
            'therapist' => $user,
            'inactiveTherapists' => $inactiveTherapists,
            'incompleteTherapists' => $incompleteTherapists,
            'activeTherapists' => $activeTherapists,
            'unverifiedTherapists' => $unverifiedTherapists,
        ]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $therapist = User::find($id);
        $clients = $therapist->clients()->get();
        // $clients = $therapist->clients()->orderBy('preferred_name', 'asc')->get();
        $therapySessions = TherapySession::where('client_id', '=', $therapist->id)->get();
        $file_name = FileUpload::find($id);

        $totalSessionCost = number_format($therapist->sum('session_cost'), 2, '.', '');
        $totalClientContribution = number_format($clients->sum('client_contribution'), 2, '.', '');
        $total = number_format($totalSessionCost - $totalClientContribution, 2, '.', '');

        $totalClients = $clients->count();

        $space_for_new_clients = (int) $therapist->number_of_potential_clients - $totalClients;

        return view('therapist.show', [
            'therapist' => $therapist,
            'therapySessions' => $therapySessions,
            'clients' => $clients,
            'user' => $user,
            'file_name' => $file_name,
            'space_for_new_clients' => $space_for_new_clients,
            'total' => $total,
            'totalSessionCost' => $totalSessionCost,
            'totalClientContribution' => $totalClientContribution,
        ]);
    }

    private function getGenders()
    {
        $genders = [
            'Male',
            'Female',
            'Transgender',
            'Genderqueer',
            'Genderfluid',
            'Agender',
            'Bigender',
            'Cisgender',
            'Non-Binary',
            'Prefer Not To Say',
        ];

        return $genders;
    }

    public function edit($id)
    {
        $user = auth()->user();
        if ($user && $user->admin == 1) {
            $therapist = User::find($id);
            $form = $therapist->therapist;

            // dd($therapist);
            return view('therapist.edit', [
                'therapist' => $therapist,
                'user' => $user,
                'form' => $form,
                'id' => $id,
                'genders' => $this->getGenders(),
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this therapist');
        }
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $selectedGenders = $request->input('gender');
        $otherGender = $request->input('otherGender');
        // $genderString = "";
        if (is_array($selectedGenders)) {
            if (in_array('Other', $selectedGenders) && $otherGender) {
                $genderString = implode(', ', array_map(function ($value) use ($otherGender) {
                    return $value == 'Other' ? $otherGender : $value;
                }, $selectedGenders));
            } else {
                $genderString = implode(', ', $selectedGenders);
            }
        } else {
            $genderString = $selectedGenders;
        }

        if ($user->admin == 1) {
            $max_session_cost = 500;
        } else {
            $max_session_cost = 100;
        }

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            // 'gender' => 'nullable|string|max:255',
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
            'session_cost' => 'nullable|numeric|max:'.$max_session_cost,
            // 'client_extensions' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
            'number_of_potential_clients' => 'nullable|numeric',
            'currency' => 'nullable|string|max:255',
            'client_extensions' => 'nullable|numeric',

            // New field for invoice payee
            'invoice_payee' => 'nullable|string|max:255',

            // 'gender' => $genderString

        ]);

        // Log('User currency: ' . $user->currency);

        $user = User::find($id);

        $validatedData['gender'] = $genderString;

        // If invoice_payee is not set, default to therapist's name
        if (empty($validatedData['invoice_payee'])) {
            $validatedData['invoice_payee'] = $user->name;
        }

        // $user->currency = $request->currencyCode;

        if (! $user) {
            return redirect()->route('therapist.show', $id)->with('error', 'User not found');
        }

        // Check if address fields have changed before updating
        $addressFieldsChanged = $this->hasAddressChanged($user, $validatedData);

    $user->update($validatedData);

        // Send W9/W8BEN reminder email if address changed and user is not an admin
        if ($addressFieldsChanged && ! $user->isAdmin()) {
            Mail::to($user->email)->send(new TherapistAddressUpdatedW9Reminder($user));
        }

        return redirect()->back()->with('success', 'Profile updated!');
    }

    public function sendLastMonthInvoice($id)
    {
        $user = auth()->user();

        // Check if user is admin
        if (! $user || $user->admin != 1) {
            return redirect()->back()->with('error', 'You are not authorized to send invoices.');
        }

        $therapist = User::find($id);
        if (! $therapist) {
            return redirect()->back()->with('error', 'Therapist not found.');
        }

        $now = Carbon::now();
        $start = $now->copy()->subMonth()->startOfMonth();
        $end = $now->copy()->subMonth()->endOfMonth();

        // Get sessions for the previous month
        $sessions = TherapySession::where('user_id', $therapist->id)
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy('client_id');

        if ($sessions->isEmpty()) {
            return redirect()->back()->with('error', 'No sessions found for last month for this therapist.');
        }

        // Prepare session summary per client
        $sessionSummary = [];
        foreach ($sessions as $clientId => $clientSessions) {
            $client = $clientSessions->first()->client;

            // Calculate totals for this client
            $totalSessionCost = $clientSessions->sum('session_cost');
            $totalClientContribution = $clientSessions->sum('client_contribution');
            $totalRemainingContribution = $clientSessions->sum('remaining_client_contribution');

            $sessionSummary[] = [
                'client_id' => $clientId,
                'client_code' => $client ? $client->client_code : null,
                'quantity' => $clientSessions->count(),
                'sessions' => $clientSessions,
                'total_session_cost' => $totalSessionCost,
                'total_client_contribution' => $totalClientContribution,
                'total_remaining_contribution' => $totalRemainingContribution,
            ];
        }

        $invoiceNumber = 'INV-'.$therapist->id.'-'.$now->format('Ym');
        $invoiceDate = $now->format('Y-m-d');

        // Generate PDF
        $pdf = Pdf::loadView('invoices.therapist', [
            'therapist' => $therapist,
            'sessionSummary' => $sessionSummary,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'period' => [$start->format('Y-m-d'), $end->format('Y-m-d')],
            'currencySymbol' => $this->getCurrencySymbol($therapist->currency),
            'invoicePayee' => $therapist->invoice_payee ?? $therapist->name,
        ]);

        $filename = 'Invoice_'.$therapist->id.'_'.$now->format('Ym').'.pdf';

        // Send email to the current admin (who clicked the button)
        try {
            Mail::send('emails.therapist_invoice', [
                'therapist' => $therapist,
                'invoiceNumber' => $invoiceNumber,
                'invoiceDate' => $invoiceDate,
            ], function ($message) use ($pdf, $filename, $user) {
                $message->to($user->email)
                    ->subject('Therapist Invoice - Last Month')
                    ->attachData($pdf->output(), $filename);
            });

            return redirect()->back()->with('success', "Last month's invoice for {$therapist->name} has been sent to your email ({$user->email}).");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send invoice: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if ($user && $user->admin == 1) {
            $therapist = User::find($id);
            if ($therapist) {
                $therapist->delete();

                return redirect()->route('therapists.index')->with('success', 'Therapist deleted successfully.');
            }

            return redirect()->route('therapists.index')->with('error', 'Therapist not found.');
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this therapist');
        }
    }

    /**
     * Check if any address-related fields have changed.
     */
    private function hasAddressChanged(User $user, array $validatedData): bool
    {
        $addressFields = [
            'street_address',
            'county_town',
            'state',
            'zip_code_postal_code',
            'country',
        ];

        foreach ($addressFields as $field) {
            if (isset($validatedData[$field]) && $validatedData[$field] !== $user->$field) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get currency symbol from currency code.
     */
    private function getCurrencySymbol(?string $currencyCode): string
    {
        $currencySymbols = [
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            'JPY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'SEK' => 'kr',
            'NZD' => 'NZ$',
            'MXN' => '$',
            'SGD' => 'S$',
            'HKD' => 'HK$',
            'NOK' => 'kr',
            'KRW' => '₩',
            'TRY' => '₺',
            'RUB' => '₽',
            'INR' => '₹',
            'BRL' => 'R$',
            'ZAR' => 'R',
            'PHP' => '₱',
            'CZK' => 'Kč',
        ];

        return $currencySymbols[$currencyCode] ?? '$'; // Default to $ (USD)
    }
}
