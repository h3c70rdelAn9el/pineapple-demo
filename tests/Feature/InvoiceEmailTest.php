<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvoiceEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_sent_to_invoice_email_when_set(): void
    {
        Mail::fake();

        // Create admin user
        $admin = User::factory()->create([
            'admin' => 1,
            'email' => 'admin@example.com',
        ]);

        // Create therapist with invoice_email set
        $therapist = User::factory()->create([
            'admin' => 0,
            'email' => 'therapist@example.com',
            'invoice_email' => 'billing@example.com',
            'session_cost' => 50.00,
        ]);

        // Create a client for the therapist
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
            'client_contribution' => 100.00,
        ]);

        // Create a session from last month
        TherapySession::factory()->create([
            'user_id' => $therapist->id,
            'client_id' => $client->id,
            'session_cost' => 50.00,
            'attendance' => 'attended',
            'created_at' => now()->subMonth(),
        ]);

        // Act as admin and send invoice
        $this->actingAs($admin);
        $response = $this->post(route('therapist.send-invoice', $therapist->id));

        // Assert success message includes the invoice_email
        $response->assertSessionHas('success');
        $this->assertStringContainsString('billing@example.com', session('success'));
    }

    public function test_invoice_sent_to_regular_email_when_invoice_email_not_set(): void
    {
        Mail::fake();

        // Create admin user
        $admin = User::factory()->create([
            'admin' => 1,
            'email' => 'admin@example.com',
        ]);

        // Create therapist WITHOUT invoice_email set
        $therapist = User::factory()->create([
            'admin' => 0,
            'email' => 'therapist@example.com',
            'invoice_email' => null,
            'session_cost' => 50.00,
        ]);

        // Create a client for the therapist
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
            'client_contribution' => 100.00,
        ]);

        // Create a session from last month
        TherapySession::factory()->create([
            'user_id' => $therapist->id,
            'client_id' => $client->id,
            'session_cost' => 50.00,
            'attendance' => 'attended',
            'created_at' => now()->subMonth(),
        ]);

        // Act as admin and send invoice
        $this->actingAs($admin);
        $response = $this->post(route('therapist.send-invoice', $therapist->id));

        // Assert success message includes the regular email
        $response->assertSessionHas('success');
        $this->assertStringContainsString('therapist@example.com', session('success'));
    }

    public function test_admin_can_update_invoice_email(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Create therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'email' => 'therapist@example.com',
            'invoice_email' => null,
        ]);

        // Act as admin and update therapist with invoice_email
        $this->actingAs($admin);
        $response = $this->put(route('therapist.update', $therapist->id), [
            'name' => $therapist->name,
            'email' => $therapist->email,
            'invoice_email' => 'billing@company.com',
        ]);

        // Assert therapist was updated
        $therapist->refresh();
        $this->assertEquals('billing@company.com', $therapist->invoice_email);
    }

    public function test_invoice_email_field_only_visible_to_admin(): void
    {
        // Create non-admin therapist
        $therapist = User::factory()->create([
            'admin' => 0,
        ]);

        // Act as therapist (non-admin)
        $this->actingAs($therapist);
        $response = $this->get(route('therapist.edit', $therapist->id));

        // Assert the invoice_email field is NOT visible (wrapped in @if(auth()->user()->admin == 1))
        $response->assertDontSee('Invoice Email (Admin Only)');
    }

    public function test_invoice_email_field_visible_to_admin(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Create therapist
        $therapist = User::factory()->create([
            'admin' => 0,
        ]);

        // Act as admin
        $this->actingAs($admin);
        $response = $this->get(route('therapist.edit', $therapist->id));

        // Assert the invoice_email field IS visible
        $response->assertSee('Invoice Email (Admin Only)');
    }
}
