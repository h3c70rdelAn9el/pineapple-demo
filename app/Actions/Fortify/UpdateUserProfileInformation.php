<?php

namespace App\Actions\Fortify;

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\FileUpload;
use App\Models\User;
use App\Notifications\TherapistProfileUpdated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @return void
     */
    public function update($user, array $input)
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'admin' => ['nullable', 'boolean'],
            'license' => ['nullable', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'active-status' => ['nullable', 'boolean'],
            'all_documents' => ['nullable', 'string', 'max:255'],
            'annual_contact_about_complaints_uk_date' => ['boolean', 'nullable'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
            'certificate' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            'client_extensions' => ['nullable', 'string', 'max:255'],
            'clinical_license' => ['nullable', 'boolean'],
            'clinical_license_verification_portal' => ['nullable', 'string', 'max:255'],
            'contact_for_promotionals' => ['nullable', 'boolean'],
            'country' => ['nullable', 'string', 'max:255'],
            'county_town' => ['nullable', 'string', 'max:255'],
            'dropbox' => ['nullable', 'boolean'],
            'full' => ['nullable', 'boolean'],
            'gender' => ['nullable', 'string', 'max:255'],
            'headshot' => ['nullable', 'boolean'],
            'iban_swift_code' => ['nullable', 'string', 'max:255'],
            'insurance' => ['nullable', 'boolean'],
            'intern' => ['nullable', 'boolean'],
            'leah_signed' => ['nullable', 'boolean'],
            'out_of_state_coaching' => ['nullable', 'boolean'],
            'preferred_name' => ['nullable', 'string', 'max:255'],
            'quickbooks' => ['nullable', 'boolean'],
            'registered' => ['nullable', 'boolean'],
            'response' => ['nullable', 'boolean'],
            'routing_number' => ['nullable', 'string', 'max:255'],
            'session_cost' => ['nullable', 'numeric'],
            'signed_documents' => ['nullable', 'boolean'],
            'space_for_new_clients' => ['nullable', 'boolean'],
            'state' => ['nullable', 'string', 'max:255'],
            'state_license_board' => ['nullable', 'string', 'max:255'],
            'street_address' => ['nullable', 'string', 'max:255'],
            'supervisor_name' => ['nullable', 'string', 'max:255'],
            'time_zone' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'voided_cheque' => ['nullable', 'boolean'],
            'w9' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            'website' => ['nullable', 'boolean'],
            'zip_code_postal_code' => ['nullable', 'string', 'max:255'],
            'contract_signed' => ['nullable', 'boolean'],
            'number_of_potential_clients' => ['nullable', 'numeric'],
            'file_upload' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            'currency' => ['nullable', 'string', 'max:255'],

        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (isset($input['certificate'])) {
            $certificatePath = $input['certificate']->store('certificates', 'public');
            $user->update(['certificate' => $certificatePath]);
        }

        if (isset($input['w9'])) {
            $w9Path = $input['w9']->store('w9s', 'public');
            $user->update(['w9' => $w9Path]);
        }
        /*
        if (isset($input['file_upload'])) {
            $fileUploadPath = $input['file_upload']->store('file_uploads', 'public');
            $user->update(['file_upload' => $fileUploadPath]);
            $admin = User::where('admin', 1)->first();
            if ($admin) {
                $admin->notify(new FileUpload($user));
            }
        }
        */

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Check if address fields have changed before updating
            $addressFieldsChanged = $this->hasAddressChanged($user, $input);

            $user->forceFill([
                'account_name' => $input['account_name'],
                'account_number' => $input['account_number'],
                'active_status' => $input['active_status'],
                'admin' => $input['admin'],
                'all_documents' => $input['all_documents'],
                'annual_contact_about_complaints_uk_date' => $input['annual_contact_about_complaints_uk_date'],
                'avatar' => $input['avatar'],
                'bio' => $input['bio'],
                'certificate' => $input['certificate'],
                'client_extensions' => $input['client_extensions'],
                'clinical_license' => $input['clinical_license'],
                'clinical_license_verification_portal' => $input['clinical_license_verification_portal'],
                'contact_for_promotionals' => $input['contact_for_promotionals'],
                'country' => $input['country'],
                'county_town' => $input['county_town'],
                'dropbox' => $input['dropbox'],
                'email' => $input['email'],
                'expires_at' => $input['expires_at'],
                'full' => $input['full'],
                'gender' => $input['gender'],
                'headshot' => $input['headshot'],
                'iban_swift_code' => $input['iban_swift_code'],
                'insurance' => $input['insurance'],
                'intern' => $input['intern'],
                'leah_signed' => $input['leah_signed'],
                'license' => $input['license'],
                'name' => $input['name'],
                'out_of_state_coaching' => $input['out_of_state_coaching'],
                'preferred_name' => $input['preferred_name'],
                'quickbooks' => $input['quickbooks'],
                'registered' => $input['registered'],
                'response' => $input['response'],
                'routing_number' => $input['routing_number'],
                'session_cost' => $input['session_cost'],
                'signed_documents' => $input['signed_documents'],
                'space_for_new_clients' => $input['space_for_new_clients'],
                'state' => $input['state'],
                'state_license_board' => $input['state_license_board'],
                'street_address' => $input['street_address'],
                'supervisor_name' => $input['supervisor_name'],
                'time_zone' => $input['time_zone'],
                'title' => $input['title'],
                'voided_cheque' => $input['voided_cheque'],
                'w9' => $input['w9'],
                'website' => $input['website'],
                'zip_code_postal_code' => $input['zip_code_postal_code'],
                'contract_signed' => $input['contract_signed'],
                'number_of_potential_clients' => $input['number_of_potential_clients'],
                'file_upload' => $input['file_upload'],
                'currency' => $input['currencyCode'],

            ])->save();

            // Send W9/W8BEN reminder email if address changed and user is not an admin
            if ($addressFieldsChanged && ! $user->isAdmin()) {
                Mail::to($user->email)->send(new TherapistAddressUpdatedW9Reminder($user));
            }

            if (! $user->isAdmin()) {
                $admins = User::where('admin', 1)->get();
                foreach ($admins as $admin) {
                    $admin->notify(new TherapistProfileUpdated($user, []));
                }
            }

            $user->notify(new TherapistProfileUpdated($user, []));

        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        // Check if address fields have changed before updating
        $addressFieldsChanged = $this->hasAddressChanged($user, $input);

        $user->forceFill([
            'account_name' => $input['account_name'],
            'account_number' => $input['account_number'],
            'active_status' => $input['active_status'],
            'admin' => $input['admin'],
            'all_documents' => $input['all_documents'],
            'annual_contact_about_complaints_uk_date' => $input['annual_contact_about_complaints_uk_date'],
            'avatar' => $input['avatar'],
            'bio' => $input['bio'],
            'certificate' => $input['certificate'],
            'client_extensions' => $input['client_extensions'],
            'clinical_license' => $input['clinical_license'],
            'clinical_license_verification_portal' => $input['clinical_license_verification_portal'],
            'contact_for_promotionals' => $input['contact_for_promotionals'],
            'country' => $input['country'],
            'county_town' => $input['county_town'],
            'dropbox' => $input['dropbox'],
            'email' => $input['email'],
            'expires_at' => $input['expires_at'],
            'full' => $input['full'],
            'gender' => $input['gender'],
            'headshot' => $input['headshot'],
            'iban_swift_code' => $input['iban_swift_code'],
            'insurance' => $input['insurance'],
            'intern' => $input['intern'],
            'leah_signed' => $input['leah_signed'],
            'license' => $input['license'],
            'name' => $input['name'],
            'out_of_state_coaching' => $input['out_of_state_coaching'],
            'preferred_name' => $input['preferred_name'],
            'quickbooks' => $input['quickbooks'],
            'registered' => $input['registered'],
            'response' => $input['response'],
            'routing_number' => $input['routing_number'],
            'session_cost' => $input['session_cost'],
            'signed_documents' => $input['signed_documents'],
            'space_for_new_clients' => $input['space_for_new_clients'],
            'state' => $input['state'],
            'state_license_board' => $input['state_license_board'],
            'street_address' => $input['street_address'],
            'supervisor_name' => $input['supervisor_name'],
            'time_zone' => $input['time_zone'],
            'title' => $input['title'],
            'voided_cheque' => $input['voided_cheque'],
            'w9' => $input['w9'],
            'website' => $input['website'],
            'zip_code_postal_code' => $input['zip_code_postal_code'],
            'contract_signed' => $input['contract_signed'],
            'number_of_potential_clients' => $input['number_of_potential_clients'],
            'file_upload' => $input['file_upload'],
            'currency' => $input['currencyCode'],

        ])->save();

        // Send W9/W8BEN reminder email if address changed and user is not an admin
        if ($addressFieldsChanged && ! $user->isAdmin()) {
            Mail::to($user->email)->send(new TherapistAddressUpdatedW9Reminder($user));
        }

        if (! $user->isAdmin()) {
            $admins = User::where('admin', 1)->get();
            foreach ($admins as $admin) {
                $admin->notify(new TherapistProfileUpdated($user, []));
            }
        }

        $user->sendEmailVerificationNotification();
    }

    /**
     * Check if any address-related fields have changed.
     */
    private function hasAddressChanged($user, array $input): bool
    {
        $addressFields = [
            'street_address',
            'county_town',
            'state',
            'zip_code_postal_code',
            'country',
        ];

        foreach ($addressFields as $field) {
            if (isset($input[$field]) && $input[$field] !== $user->$field) {
                return true;
            }
        }

        return false;
    }
}
