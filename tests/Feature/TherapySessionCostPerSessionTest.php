<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TherapySessionCostPerSessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_session_uses_client_cost_per_session_override_when_set(): void
    {
        // Create a therapist with a default session cost
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 50.00,
        ]);

        // Create a client with a cost per session override
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'category' => 'Active',
            'cost_per_session' => 75.00,
            'max_sessions' => 20,
            'client_contribution' => 100.00,
        ]);

        // Act as the therapist and create a session
        $this->actingAs($therapist);

        $response = $this->post(route('session.store'), [
            'client_id' => $client->id,
            'created_at' => now(),
            'attendance' => 'attended',
            'notes' => 'Test session',
        ]);

        $response->assertSessionHasNoErrors();

        // Get the created session
        $session = TherapySession::where('client_id', $client->id)->first();

        // Assert that the session cost matches the client's override, not the therapist's default
        $this->assertEquals(75.00, $session->session_cost);
        $this->assertNotEquals(50.00, $session->session_cost);
    }

    public function test_session_uses_therapist_default_when_client_override_not_set(): void
    {
        // Create a therapist with a default session cost
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 50.00,
        ]);

        // Create a client without cost per session override
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'category' => 'Active',
            'cost_per_session' => null,
            'max_sessions' => 20,
            'client_contribution' => 100.00,
        ]);

        // Act as the therapist and create a session
        $this->actingAs($therapist);

        $response = $this->post(route('session.store'), [
            'client_id' => $client->id,
            'created_at' => now(),
            'attendance' => 'attended',
            'notes' => 'Test session',
        ]);

        $response->assertSessionHasNoErrors();

        // Get the created session
        $session = TherapySession::where('client_id', $client->id)->first();

        // Assert that the session cost matches the therapist's default session cost
        $this->assertEquals(50.00, $session->session_cost);
    }

    public function test_special_session_has_zero_cost_regardless_of_override(): void
    {
        // Create a therapist with a default session cost
        $therapist = User::factory()->create([
            'admin' => 0,
            'session_cost' => 50.00,
        ]);

        // Create a client with special sessions enabled and a cost per session override
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'category' => 'Active',
            'cost_per_session' => 75.00,
            'special_sessions' => true,
            'max_sessions' => 20,
            'client_contribution' => 100.00,
        ]);

        // Act as the therapist and create a session
        $this->actingAs($therapist);

        $response = $this->post(route('session.store'), [
            'client_id' => $client->id,
            'created_at' => now(),
            'attendance' => 'attended',
            'notes' => 'Special session',
        ]);

        $response->assertSessionHasNoErrors();

        // Get the created session
        $session = TherapySession::where('client_id', $client->id)->first();

        // Assert that special sessions always have zero cost
        $this->assertEquals(0, $session->session_cost);
        $this->assertTrue($session->special);
    }
}
