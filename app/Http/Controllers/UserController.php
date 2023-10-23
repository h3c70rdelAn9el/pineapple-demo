<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateUserProfile(Request $request)
    {
        $user = User::find(auth()->user()->id);

        // dd($request->all());

        // $validated = ([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'license' => $request->license,
        //     'certificate' => $request->certificate,
        //     'expires_at' => $request->expires_at,
        //     'account_name' => $request->account_name,
        //     'account_number' => $request->account_number,
        //     'routing_number' => $request->routing_number,
        //     'on_vacation' => $request->on_vacation,
        //     'clinical_license_verification_portal' => $request->clinical_license_verification_portal,
        //     'title' => $request->title,
        //     'preferred_name' => $request->preferred_name,
        //     'intern' => $request->intern,
        //     'supervisor_name' => $request->supervisor_name,
        //     'street_address' => $request->street_address,
        //     'zip_code_postal_code' => $request->zip_code_postal_code,
        //     'iban_swift_code' => $request->iban_swift_code,
        //     'contract_signed' => $request->contract_signed,
        //     'all_documents' => $request->all_documents,
        //     'full' => $request->full,
        //     'session_cost' => $request->session_cost,
        //     'contact_for_promotionals' => $request->contact_for_promotionals,
        //     'number_of_potential_clients' => $request->number_of_potential_clients,
        //     'out_of_state_coaching' => $request->out_of_state_coaching,
        //     // 'file_upload' => $request->file_upload,
        //     'w9' => $request->w9,
        //     'headshot' => $request->headshot,
        //     'voided_cheque' => $request->voided_cheque,
        //     'bio' => $request->bio,
        //     'website' => $request->website,
        //     'quickbooks' => $request->quickbooks,
        //     'dropbox' => $request->dropbox,
        //     'client_extensions' => $request->client_extensions,
        //     'notes' => $request->notes,
        //     'covid_fundraise' => $request->covid_fundraise,
        //     'insurance' => $request->insurance,
        //     'signed_documents' => $request->signed_documents,
        //     'leah_signed' => $request->leah_signed,
        //     'space_for_new_clients' => $request->space_for_new_clients,
        //     'admin' => $request->admin,
        //     'county_town' => $request->county_town,
        //     'country' => $request->country,
        //     'state' => $request->state,
        // ]);

        $validated = $request->validate([
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
            'session_cost' => 'nullable|numeric',
            'contact_for_promotionals' => 'nullable|boolean',
            'number_of_potential_clients' => 'nullable|string|max:255',
            'out_of_state_coaching' => 'nullable|boolean',
            // 'file_upload' => $request->file_upload,
            'w9' => 'nullable|boolean',
            'headshot' => 'nullable|boolean',
            'voided_cheque' => 'nullable|boolean',
            'bio' => 'nullable|boolean',
            'website' => 'nullable|boolean',
            'quickbooks' => 'nullable|boolean',
            'dropbox' => 'nullable|boolean',
            'client_extensions' => 'nullable|boolean',
            'notes' => 'nullable|string|max:255',
            'covid_fundraise' => 'nullable|boolean',
            'insurance' => 'nullable|boolean',
            'signed_documents' => 'nullable|boolean',
            'leah_signed' => 'nullable|boolean',
            'space_for_new_clients' => 'nullable|numerical',
            'admin' => 'nullable|boolean',
            'county_town' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',





        ]);

        $user->update($validated);


        return redirect()->route('dashboard');
    }
}
