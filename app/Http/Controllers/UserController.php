<?php

namespace App\Http\Controllers;

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\User;
use App\Notifications\TherapistProfileUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function updateUserProfile(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'license' => 'nullable|string|max:255',
            'certificate' => 'nullable|string|max:255',
            'expires_at' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'routing_number' => 'nullable|string|max:255',
            'on_vacation' => 'nullable|string|max:255',
            'clinical_license_verification_portal' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'intern' => 'nullable|boolean',
            'supervisor_name' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'zip_code_postal_code' => 'nullable|string|max:255',
            'iban_swift_code' => 'nullable|string|max:255',
            'contract_signed' => 'nullable|boolean',
            'all_documents' => 'nullable|string|max:255',
            'full' => 'nullable|boolean',
            'session_cost' => 'nullable|numeric|max:100',
            'contact_for_promotionals' => 'nullable|boolean',
            'number_of_potential_clients' => 'nullable|string|max:255',
            'out_of_state_coaching' => 'nullable|boolean',
            'client_extensions' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
            'covid_fundraise' => 'nullable|boolean',
            'insurance' => 'nullable|boolean',
            'space_for_new_clients' => 'nullable|numeric',
            'county_town' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'selectedGenders' => 'nullable|array',
            'currency' => 'nullable|string|max:255',

        ]);

        if ($request->has('selectedGenders')) {
            $validatedData['gender'] = implode(', ', $validatedData['selectedGenders']);
        } else {
            $validatedData['gender'] = null;
        }

        // Check if address fields have changed before updating
        $addressFieldsChanged = $this->hasAddressChanged($user, $validatedData);

        $user->update($validatedData);

        // Send W9/W8BEN reminder email if address changed and user is not an admin
        if ($addressFieldsChanged && ! $user->isAdmin()) {
            Mail::to($user->email)->send(new TherapistAddressUpdatedW9Reminder($user));
        }

        $updatedFields = array_intersect_key($validatedData, $user->getChanges());

        $admins = User::where('admin', 1)->get();
        foreach ($admins as $admin) {
            $admin->notify(new TherapistProfileUpdated($user, $updatedFields));
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updateGender(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $validatedData = $request->validate([
            'selectedGenders' => 'nullable|array',
        ]);

        $user->update(['gender' => implode(', ', $validatedData['selectedGenders'])]);

        return redirect()->back()->with('success', 'Gender updated successfully.');
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
