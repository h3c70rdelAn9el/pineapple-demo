<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use App\Models\TherapySession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionLimitConditionalTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_with_max_sessions_over_15_gets_status_changed_when_limit_reached(): void
    {
        $client = Client::factory()->create([
            'max_sessions' => 20,
            'status' => 0, // Active
        ]);

        $therapist = User::factory()->create();

        // Create 20 attended sessions to reach the limit
        for ($i = 0; $i < 20; $i++) {
            TherapySession::factory()->create([
                'client_id' => $client->id,
                'user_id' => $therapist->id,
                'attendance' => 'attended',
            ]);
        }

        // Simulate adding another session which should trigger the status change
        $response = $this->actingAs($therapist)->post(route('session.store'), [
            'client_id' => $client->id,
            'session_cost' => 100,
            'client_contribution' => 0,
            'remaining_client_contribution' => 100,
            'attendance' => 'attended',
            'notes' => 'Test session',
            'created_at' => now(),
        ]);

        $client->refresh();
        $this->assertEquals(1, $client->status); // Should be inactive
    }

    public function test_client_with_max_sessions_15_or_under_does_not_get_status_changed(): void
    {
        $client = Client::factory()->create([
            'max_sessions' => 15,
            'status' => 0, // Active
        ]);

        $therapist = User::factory()->create();

        // Create 15 attended sessions to reach the limit
        for ($i = 0; $i < 15; $i++) {
            TherapySession::factory()->create([
                'client_id' => $client->id,
                'user_id' => $therapist->id,
                'attendance' => 'attended',
            ]);
        }

        // Simulate adding another session - status should NOT change since max_sessions <= 15
        $response = $this->actingAs($therapist)->post(route('session.store'), [
            'client_id' => $client->id,
            'session_cost' => 100,
            'client_contribution' => 0,
            'remaining_client_contribution' => 100,
            'attendance' => 'attended',
            'notes' => 'Test session',
            'created_at' => now(),
        ]);

        $client->refresh();
        $this->assertEquals(0, $client->status); // Should remain active
    }

    public function test_client_with_max_sessions_10_does_not_get_status_changed(): void
    {
        $client = Client::factory()->create([
            'max_sessions' => 10,
            'status' => 0, // Active
        ]);

        $therapist = User::factory()->create();

        // Create 10 attended sessions to reach the limit
        for ($i = 0; $i < 10; $i++) {
            TherapySession::factory()->create([
                'client_id' => $client->id,
                'user_id' => $therapist->id,
                'attendance' => 'attended',
            ]);
        }

        // Simulate adding another session - status should NOT change since max_sessions <= 15
        $response = $this->actingAs($therapist)->post(route('session.store'), [
            'client_id' => $client->id,
            'session_cost' => 100,
            'client_contribution' => 0,
            'remaining_client_contribution' => 100,
            'attendance' => 'attended',
            'notes' => 'Test session',
            'created_at' => now(),
        ]);

        $client->refresh();
        $this->assertEquals(0, $client->status); // Should remain active
    }
}
