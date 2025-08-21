<?php

namespace App\Http\Controllers;

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\FileUpload;
use App\Models\TherapySession;
use App\Models\User;
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

            // 'gender' => $genderString

        ]);

        // Log('User currency: ' . $user->currency);

        $user = User::find($id);

        $validatedData['gender'] = $genderString;

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
}
