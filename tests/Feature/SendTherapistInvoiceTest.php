<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendTherapistInvoiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_admin_can_send_last_month_invoice_to_themselves(): void
    {
        Mail::fake();

        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
            'email' => 'admin@test.com',
        ]);

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'active_status' => 1,
            'name' => 'Test Therapist',
            'session_cost' => 100.00,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'client_code' => 'CLIENT001',
        ]);

        // Create therapy sessions from last month
        $lastMonth = Carbon::now()->subMonth();
        TherapySession::factory()->create([
            'user_id' => $therapist->id,
            'client_id' => $client->id,
            'session_cost' => 100.00,
            'client_contribution' => 20.00,
            'remaining_client_contribution' => 80.00,
            'created_at' => $lastMonth,
        ]);

        // Act as admin and send invoice
        $response = $this->actingAs($admin)
            ->post(route('therapist.send-invoice', $therapist->id));

        // Assert redirect back with success message
        $response->assertRedirect();
        $response->assertSessionHas('success');
        // Updated to check for the therapist's email in the success message
        $this->assertStringContainsString('has been sent to', session('success'));
        $this->assertStringContainsString($therapist->email, session('success'));
    }

    public function test_non_admin_cannot_send_invoice(): void
    {
        // Create a non-admin user
        $user = User::factory()->create([
            'admin' => 0,
        ]);

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
        ]);

        // Act as non-admin user
        $response = $this->actingAs($user)
            ->post(route('therapist.send-invoice', $therapist->id));

        // Assert redirect back with error message
        $response->assertRedirect();
        $response->assertSessionHas('error', 'You are not authorized to send invoices.');
    }

    public function test_cannot_send_invoice_for_nonexistent_therapist(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Act as admin with non-existent therapist ID
        $response = $this->actingAs($admin)
            ->post(route('therapist.send-invoice', 999));

        // Assert redirect back with error message
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Therapist not found.');
    }

    public function test_cannot_send_invoice_when_no_sessions_last_month(): void
    {
        Mail::fake();

        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'active_status' => 1,
        ]);

        // Act as admin (no sessions created, so should get error)
        $response = $this->actingAs($admin)
            ->post(route('therapist.send-invoice', $therapist->id));

        // Assert redirect back with error message
        $response->assertRedirect();
        $response->assertSessionHas('error', 'No sessions found for last month for this therapist.');

        // Assert no email was sent
        Mail::assertNothingSent();
    }

    public function test_guest_cannot_access_send_invoice(): void
    {
        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
        ]);

        // Try to access without authentication
        $response = $this->post(route('therapist.send-invoice', $therapist->id));

        // Should redirect to login
        $response->assertRedirect(route('login'));
    }
}
