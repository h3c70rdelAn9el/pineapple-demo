<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\FileUpload;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Notifications\TherapistProfileUpdated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            // TODO: CAHNGE  TO LEGAL_NAME
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'license' => ['nullable', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'on_vacation' => ['required', 'boolean'],
            'certificate' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            'w9' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            //'file_upload' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            'routing_number' => ['nullable', 'string', 'max:255'],
            'clinical_license_verification_portal' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'preferred_name' => ['nullable', 'string', 'max:255'],
            'intern' => ['nullable', 'boolean'],
            'supervisor_name' => ['nullable', 'string', 'max:255'],
            'street_address' => ['nullable', 'string', 'max:255'],
            'zip_code_postal_code' => ['nullable', 'string', 'max:255'],
            'county_town' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'time_zone' => ['nullable', 'string', 'max:255'],
            'iban_swift_code' => ['nullable', 'string', 'max:255'],
            'contract_signed' => ['nullable', 'boolean'],
            'all_documents' => ['nullable', 'string', 'max:255'],
            'full' => ['nullable', 'boolean'],
            'session_cost' => ['nullable', 'numeric'],
            'contact_for_promotionals' => ['nullable', 'boolean'],
            'number_of_potential_clients' => ['nullable', 'numeric'],
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
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'license' => $input['license'],
                'expires_at' => $input['expires_at'],
                'account_name' => $input['account_name'],
                'account_number' => $input['account_number'],
                'on_vacation' => $input['on_vacation'],
                'certificate' => $input['certificate'],
                'w9' => $input['w9'],
                //'file_upload' => $input['file_upload'],
                'routing_number' => $input['routing_number'],
                'clinical_license_verification_portal' => $input['clinical_license_verification_portal'],
                'title' => $input['title'],
                'preferred_name' => $input['preferred_name'],
                'intern' => $input['intern'],
                'supervisor_name' => $input['supervisor_name'],
                'street_address' => $input['street_address'],
                'zip_code_postal_code' => $input['zip_code_postal_code'],
                'county_town' => $input['county_town'] ?? '',
                'country' => $input['country'],
                'time_zone' => $input['time_zone'],
                'iban_swift_code' => $input['iban_swift_code'],
                'contract_signed' => $input['contract_signed'],
                'all_documents' => $input['all_documents'],
                'full' => $input['full'],
                'session_cost' => $input['session_cost'],
                'contact_for_promotionals' => $input['contact_for_promotionals'],
                'number_of_potential_clients' => $input['number_of_potential_clients'],
            ])->save();

            if (!$user->isAdmin()) {
                $admin = User::where('admin', 1)->first();
                if ($admin) {
                    $admin->notify(new TherapistProfileUpdated($user));
                }
            }

            $user->notify(new TherapistProfileUpdated($user));

        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'on_vacation' => $input['on_vacation'],
            'license' => $input['license'],
            'expires_at' => $input['expires_at'],
            'account_name' => $input['account_name'],
            'account_number' => $input['account_number'],
            'certificate' => $input['certificate'],
            'w9' => $input['w9'],
            //'file_upload' => $input['file_upload'],
            'routing_number' => $input['routing_number'],
            'clinical_license_verification_portal' => $input['clinical_license_verification_portal'],
            'title' => $input['title'],
            'preferred_name' => $input['preferred_name'],
            'intern' => $input['intern'],
            'supervisor_name' => $input['supervisor_name'],
            'street_address' => $input['street_address'],
            'zip_code_postal_code' => $input['zip_code_postal_code'],
            'county_town' => $input['county_town'],
            'country' => $input['country'],
            'time_zone' => $input['time_zone'],
            'iban_swift_code' => $input['iban_swift_code'],
            'contract_signed' => $input['contract_signed'],
            'all_documents' => $input['all_documents'],
            'full' => $input['full'],
            'session_cost' => $input['session_cost'],
            'contact_for_promotionals' => $input['contact_for_promotionals'],
            'number_of_potential_clients' => $input['number_of_potential_clients'],
        ])->save();

        if (!$user->isAdmin()) {
            $admin = User::where('admin', 1)->first();
            if ($admin) {
                $admin->notify(new TherapistProfileUpdated($user));
            }
        }



        $user->sendEmailVerificationNotification();
    }
}
