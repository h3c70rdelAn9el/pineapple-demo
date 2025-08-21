<?php

namespace Tests\Feature;

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TherapistAddressUpdateEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_sent_when_therapist_address_is_updated(): void
    {
        Mail::fake();

        // Create a therapist user
        $therapist = User::factory()->create([
            'admin' => false,
            'street_address' => '123 Old Street',
            'county_town' => 'Old Town',
            'state' => 'CA',
            'zip_code_postal_code' => '12345',
            'country' => 'US',
        ]);

        // Update the therapist's address using the UpdateUserProfileInformation action
        $updateAction = new \App\Actions\Fortify\UpdateUserProfileInformation;

        $input = [
            'name' => $therapist->name,
            'email' => $therapist->email,
            'street_address' => '456 New Street', // Changed
            'county_town' => 'New Town', // Changed
            'state' => 'CA',
            'zip_code_postal_code' => '54321', // Changed
            'country' => 'US',
            // Add other required fields
            'admin' => false,
            'account_name' => null,
            'account_number' => null,
            'active_status' => null,
            'all_documents' => null,
            'annual_contact_about_complaints_uk_date' => null,
            'avatar' => null,
            'bio' => null,
            'certificate' => null,
            'client_extensions' => null,
            'clinical_license' => null,
            'clinical_license_verification_portal' => null,
            'contact_for_promotionals' => null,
            'country' => 'US',
            'county_town' => 'New Town',
            'dropbox' => null,
            'expires_at' => null,
            'full' => null,
            'gender' => null,
            'headshot' => null,
            'iban_swift_code' => null,
            'insurance' => null,
            'intern' => null,
            'leah_signed' => null,
            'license' => null,
            'out_of_state_coaching' => null,
            'preferred_name' => null,
            'quickbooks' => null,
            'registered' => null,
            'response' => null,
            'routing_number' => null,
            'session_cost' => null,
            'signed_documents' => null,
            'space_for_new_clients' => null,
            'state_license_board' => null,
            'supervisor_name' => null,
            'time_zone' => null,
            'title' => null,
            'voided_cheque' => null,
            'w9' => null,
            'website' => null,
            'contract_signed' => null,
            'number_of_potential_clients' => null,
            'file_upload' => null,
            'currencyCode' => null,
        ];

        $updateAction->update($therapist, $input);

        // Assert that the W9 reminder email was sent
        Mail::assertSent(TherapistAddressUpdatedW9Reminder::class, function ($mail) use ($therapist) {
            return $mail->hasTo($therapist->email);
        });
    }

    public function test_email_not_sent_when_admin_address_is_updated(): void
    {
        Mail::fake();

        // Create an admin user
        $admin = User::factory()->create([
            'admin' => true,
            'street_address' => '123 Old Street',
        ]);

        // Update the admin's address
        $updateAction = new \App\Actions\Fortify\UpdateUserProfileInformation;

        $input = [
            'name' => $admin->name,
            'email' => $admin->email,
            'street_address' => '456 New Street', // Changed
            'admin' => true,
            // Add other required fields...
            'account_name' => null,
            'account_number' => null,
            'active_status' => null,
            'all_documents' => null,
            'annual_contact_about_complaints_uk_date' => null,
            'avatar' => null,
            'bio' => null,
            'certificate' => null,
            'client_extensions' => null,
            'clinical_license' => null,
            'clinical_license_verification_portal' => null,
            'contact_for_promotionals' => null,
            'country' => null,
            'county_town' => null,
            'dropbox' => null,
            'expires_at' => null,
            'full' => null,
            'gender' => null,
            'headshot' => null,
            'iban_swift_code' => null,
            'insurance' => null,
            'intern' => null,
            'leah_signed' => null,
            'license' => null,
            'out_of_state_coaching' => null,
            'preferred_name' => null,
            'quickbooks' => null,
            'registered' => null,
            'response' => null,
            'routing_number' => null,
            'session_cost' => null,
            'signed_documents' => null,
            'space_for_new_clients' => null,
            'state' => null,
            'state_license_board' => null,
            'supervisor_name' => null,
            'time_zone' => null,
            'title' => null,
            'voided_cheque' => null,
            'w9' => null,
            'website' => null,
            'zip_code_postal_code' => null,
            'contract_signed' => null,
            'number_of_potential_clients' => null,
            'file_upload' => null,
            'currencyCode' => null,
        ];

        $updateAction->update($admin, $input);

        // Assert that no W9 reminder email was sent to admin
        Mail::assertNotSent(TherapistAddressUpdatedW9Reminder::class);
    }

    public function test_email_not_sent_when_non_address_fields_are_updated(): void
    {
        Mail::fake();

        // Create a therapist user
        $therapist = User::factory()->create([
            'admin' => false,
            'street_address' => '123 Old Street',
            'preferred_name' => 'Old Name',
        ]);

        // Update non-address fields
        $updateAction = new \App\Actions\Fortify\UpdateUserProfileInformation;

        $input = [
            'name' => $therapist->name,
            'email' => $therapist->email,
            'street_address' => '123 Old Street', // Unchanged
            'preferred_name' => 'New Name', // Changed, but not an address field
            'admin' => false,
            // Add other required fields...
            'account_name' => null,
            'account_number' => null,
            'active_status' => null,
            'all_documents' => null,
            'annual_contact_about_complaints_uk_date' => null,
            'avatar' => null,
            'bio' => null,
            'certificate' => null,
            'client_extensions' => null,
            'clinical_license' => null,
            'clinical_license_verification_portal' => null,
            'contact_for_promotionals' => null,
            'country' => null,
            'county_town' => null,
            'dropbox' => null,
            'expires_at' => null,
            'full' => null,
            'gender' => null,
            'headshot' => null,
            'iban_swift_code' => null,
            'insurance' => null,
            'intern' => null,
            'leah_signed' => null,
            'license' => null,
            'out_of_state_coaching' => null,
            'quickbooks' => null,
            'registered' => null,
            'response' => null,
            'routing_number' => null,
            'session_cost' => null,
            'signed_documents' => null,
            'space_for_new_clients' => null,
            'state' => null,
            'state_license_board' => null,
            'supervisor_name' => null,
            'time_zone' => null,
            'title' => null,
            'voided_cheque' => null,
            'w9' => null,
            'website' => null,
            'zip_code_postal_code' => null,
            'contract_signed' => null,
            'number_of_potential_clients' => null,
            'file_upload' => null,
            'currencyCode' => null,
        ];

        $updateAction->update($therapist, $input);

        // Assert that no W9 reminder email was sent
        Mail::assertNotSent(TherapistAddressUpdatedW9Reminder::class);
    }
}
