<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateUserProfile(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $selectedGenders = $request->input('selectedGenders');
        // $selectedGendersArray = explode(',', $selectedGenders);

        // dd($selectedGendersArray);

        // $user->gender = $selectedGendersArray;

        if (!is_array($selectedGenders)) {
            $selectedGenders = [$selectedGenders];
        }

        // $user->gender = $selectedGenders;

        // $user->gender = serialize($selectedGenders);

        $selectedGenders = $request->input('selectedGenders');

        // $genderString = implode(', ', $selectedGenders);
        // $genderString = implode(', ', $request->input('gender'));

        if (!is_array($selectedGenders)) {
            $selectedGenders = [$selectedGenders];
        }





        // if (is_array($selectedGenders) && !empty($selectedGenders)) {
        //     $genderString = implode(', ', $selectedGenders);
        // } else {
        //     $genderString = '';
        // }




        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            // 'gender' => 'nullable|string|max:255',
            // 'selectedGenders' => 'nullable|array',
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
            'session_cost' => 'nullable|numeric',
            'contact_for_promotionals' => 'nullable|boolean',
            'number_of_potential_clients' => 'nullable|string|max:255',
            'out_of_state_coaching' => 'nullable|boolean',
            // 'file_upload' => $request->file_upload,
            // 'w9' => 'nullable|boolean',
            // 'headshot' => 'nullable|boolean',
            // 'voided_cheque' => 'nullable|boolean',
            // 'bio' => 'nullable|boolean',
            // 'website' => 'nullable|boolean',
            // 'quickbooks' => 'nullable|boolean',
            // 'dropbox' => 'nullable|boolean',
            'client_extensions' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
            'covid_fundraise' => 'nullable|boolean',
            'insurance' => 'nullable|boolean',
            // 'signed_documents' => 'nullable|boolean',
            // 'leah_signed' => 'nullable|boolean',
            'space_for_new_clients' => 'nullable|numeric',
            // 'admin' => 'nullable|boolean',
            'county_town' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            // 'gender' => $genderString,

        ]);

        // $user->update([$validated, 'gender' => implode(', ', $selectedGenders)]);
        $user->fill($validated);
        $user->gender = implode(', ', $selectedGenders);
        $user->save();

        // $genderString = implode(',', $user->gender);

        // $genderArray = unserialize($user->gender);
        // if (is_array($genderArray)) {
        //     $genderString = implode(', ', $genderArray);
        // } else {
        //     $genderString = ''; // or handle the case where $genderArray is not an array
        // }

        $genderString = implode(', ', $selectedGenders);

        // $user->gender = $genderString;


        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
