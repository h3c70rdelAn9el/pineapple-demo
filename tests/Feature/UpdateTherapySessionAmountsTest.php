<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTherapySessionAmountsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_therapy_session_amounts(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
            'session_cost' => 100,
        ]);

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 100,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
        ]);

        // Create a therapy session
        $session = TherapySession::factory()->create([
            'client_id' => $client->id,
            'user_id' => $therapist->id,
            'session_cost' => 100.00,
            'client_contribution' => 50.00,
            'remaining_client_contribution' => 450.00,
            'attendance' => 'attended',
        ]);

        // Update the session amounts
        $response = $this->actingAs($admin)->patch(route('session.update', $session), [
            'session_cost' => 120.00,
            'client_contribution' => 60.00,
            'remaining_client_contribution' => 400.00,
        ]);

        $response->assertRedirect(route('session.show', $session->id));
        $response->assertSessionHas('success', 'Session amounts updated successfully.');

        // Verify the database was updated
        $this->assertDatabaseHas('therapy_sessions', [
            'id' => $session->id,
            'session_cost' => 120.00,
            'client_contribution' => 60.00,
            'remaining_client_contribution' => 400.00,
        ]);
    }

    public function test_non_admin_cannot_update_therapy_session_amounts(): void
    {
        // Create a regular therapist user
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 100,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
        ]);

        // Create a therapy session
        $session = TherapySession::factory()->create([
            'client_id' => $client->id,
            'user_id' => $therapist->id,
            'session_cost' => 100.00,
            'client_contribution' => 50.00,
            'remaining_client_contribution' => 450.00,
            'attendance' => 'attended',
        ]);

        // Try to update the session amounts as non-admin
        $response = $this->actingAs($therapist)->patch(route('session.update', $session), [
            'session_cost' => 120.00,
            'client_contribution' => 60.00,
            'remaining_client_contribution' => 400.00,
        ]);

        // Should be forbidden
        $response->assertStatus(403);

        // Verify the database was NOT updated
        $this->assertDatabaseHas('therapy_sessions', [
            'id' => $session->id,
            'session_cost' => 100.00,
            'client_contribution' => 50.00,
            'remaining_client_contribution' => 450.00,
        ]);
    }

    public function test_validation_fails_with_invalid_amounts(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
            'session_cost' => 100,
        ]);

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 100,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
        ]);

        // Create a therapy session
        $session = TherapySession::factory()->create([
            'client_id' => $client->id,
            'user_id' => $therapist->id,
            'session_cost' => 100.00,
            'client_contribution' => 50.00,
            'remaining_client_contribution' => 450.00,
            'attendance' => 'attended',
        ]);

        // Try to update with negative values
        $response = $this->actingAs($admin)->patch(route('session.update', $session), [
            'session_cost' => -10.00,
            'client_contribution' => 60.00,
            'remaining_client_contribution' => 400.00,
        ]);

        $response->assertSessionHasErrors('session_cost');

        // Try to update with non-numeric values
        $response = $this->actingAs($admin)->patch(route('session.update', $session), [
            'session_cost' => 'invalid',
            'client_contribution' => 60.00,
            'remaining_client_contribution' => 400.00,
        ]);

        $response->assertSessionHasErrors('session_cost');

        // Try to update with missing values
        $response = $this->actingAs($admin)->patch(route('session.update', $session), [
            'session_cost' => 100.00,
            'client_contribution' => 60.00,
            // missing remaining_client_contribution
        ]);

        $response->assertSessionHasErrors('remaining_client_contribution');
    }

    public function test_guest_cannot_update_therapy_session_amounts(): void
    {
        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 100,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
        ]);

        // Create a therapy session
        $session = TherapySession::factory()->create([
            'client_id' => $client->id,
            'user_id' => $therapist->id,
            'session_cost' => 100.00,
            'client_contribution' => 50.00,
            'remaining_client_contribution' => 450.00,
            'attendance' => 'attended',
        ]);

        // Try to update without authentication
        $response = $this->patch(route('session.update', $session), [
            'session_cost' => 120.00,
            'client_contribution' => 60.00,
            'remaining_client_contribution' => 400.00,
        ]);

        // Should redirect to login
        $response->assertRedirect('/login');
    }
}
