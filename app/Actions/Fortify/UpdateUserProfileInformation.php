<?php

namespace App\Actions\Fortify;

use App\Models\User;
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'license' => ['nullable', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'on_vacation' => ['required', 'boolean'],
            'certificate' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
            'w9' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:1024'],
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
                'bank_name' => $input['bank_name'],
                'account_number' => $input['account_number'],
                'on_vacation' => $input['on_vacation'],
                'certificate' => $input['certificate'],
                'w9' => $input['w9'],
            ])->save();

            if (!$user->isAdmin()) {
                $admin = User::where('admin', 1)->first();
                if ($admin) {
                    $admin->notify(new TherapistProfileUpdated($user));
                }
            }

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
            'bank_name' => $input['bank_name'],
            'account_number' => $input['account_number'],
            'certificate' => $input['certificate'],
            'w9' => $input['w9'],

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
