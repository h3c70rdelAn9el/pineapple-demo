<?php

namespace Tests\Feature;

use App\Mail\ClientMissedOneSession;
use App\Mail\ClientMissedTwoSessions;
use App\Mail\ClientMissedThreeSessions;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use App\Notifications\MissedTherapySessions;
use App\Notifications\SessionLimitNotification;
use App\Notifications\SpecialSessionsLimitNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TherapySessionEmailLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_missed_session_emails_only_sent_when_current_session_is_missed(): void
    {
        $this->withoutMiddleware();
        Mail::fake();
        Notification::fake();

        // Create a therapist user
        $therapist = User::factory()->create([
            'session_cost' => 100,
            'admin' => 0,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
            'special_sessions' => 0,
        ]);

        // Create some existing missed sessions
        TherapySession::factory()->create([
            'client_id' => $client->id,
            'user_id' => $therapist->id,
            'attendance' => 'no-show',
            'special' => false,
        ]);

        TherapySession::factory()->create([
            'client_id' => $client->id,
            'user_id' => $therapist->id,
            'attendance' => 'no-show',
            'special' => false,
        ]);

        // Now add an attended session - this should NOT trigger missed session emails
        $response = $this->actingAs($therapist)->post('/session/store', [
            'client_id' => $client->id,
            'attendance' => 'attended',
            'notes' => 'Test session',
            'created_at' => now(),
        ]);

        $response->assertRedirect();

        // Assert that NO missed session emails were sent for the attended session
        Mail::assertNotSent(ClientMissedOneSession::class);
        Mail::assertNotSent(ClientMissedTwoSessions::class);
        Mail::assertNotSent(ClientMissedThreeSessions::class);
        Notification::assertNotSentTo($client, MissedTherapySessions::class);

        // Now add a missed session - this SHOULD trigger missed session emails
        $response = $this->actingAs($therapist)->post('/session/store', [
            'client_id' => $client->id,
            'attendance' => 'no-show',
            'notes' => 'Missed session',
            'created_at' => now(),
        ]);

        $response->assertRedirect();

        // Assert that missed session emails were sent for the no-show session
        Mail::assertSent(ClientMissedThreeSessions::class);
        Notification::assertSentTo($client, MissedTherapySessions::class);
    }

    public function test_session_limit_notification_only_sent_when_reaching_limit(): void
    {
        $this->withoutMiddleware();
        Notification::fake();

        // Create a therapist user
        $therapist = User::factory()->create([
            'session_cost' => 100,
            'admin' => 0,
        ]);

        // Create a client with max_sessions = 20 (so notification at 18)
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
            'special_sessions' => 0,
        ]);

        // Create 17 existing attended sessions
        for ($i = 0; $i < 17; $i++) {
            TherapySession::factory()->create([
                'client_id' => $client->id,
                'user_id' => $therapist->id,
                'attendance' => 'attended',
                'special' => false,
            ]);
        }

        // Add the 18th session - this SHOULD trigger session limit notification
        $response = $this->actingAs($therapist)->post('/session/store', [
            'client_id' => $client->id,
            'attendance' => 'attended',
            'notes' => 'Test session',
            'created_at' => now(),
        ]);

        $response->assertRedirect();

        // Assert that session limit notification was sent
        Notification::assertSentTo($client, SessionLimitNotification::class);

        // Add the 19th session - this should NOT trigger another notification
        Notification::fake(); // Reset the fake

        $response = $this->actingAs($therapist)->post('/session/store', [
            'client_id' => $client->id,
            'attendance' => 'attended',
            'notes' => 'Another test session',
            'created_at' => now(),
        ]);

        $response->assertRedirect();

        // Assert that session limit notification was NOT sent again
        Notification::assertNotSentTo($client, SessionLimitNotification::class);
    }

    public function test_special_session_limit_notification_only_sent_when_adding_special_session(): void
    {
        $this->withoutMiddleware();
        Notification::fake();

        // Create a therapist user
        $therapist = User::factory()->create([
            'session_cost' => 100,
            'admin' => 0,
        ]);

        // Create a client with special_sessions enabled but already at the limit
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
            'special_sessions' => 1,
        ]);

        // Create 6 existing special sessions (at the limit)
        for ($i = 0; $i < 6; $i++) {
            TherapySession::factory()->create([
                'client_id' => $client->id,
                'user_id' => $therapist->id,
                'attendance' => 'attended',
                'special' => true,
            ]);
        }

        // Add a regular session - this should NOT trigger special session notification
        // Since we're at the special session limit, this will be a regular session
        $response = $this->actingAs($therapist)->post('/session/store', [
            'client_id' => $client->id,
            'attendance' => 'attended',
            'notes' => 'Regular session',
            'created_at' => now(),
        ]);

        $response->assertRedirect();

        // Assert that special session notification was NOT sent
        Notification::assertNotSentTo($therapist, SpecialSessionsLimitNotification::class);

        // Now test the notification when exactly hitting the limit
        // Create a new client with 5 special sessions
        $client2 = Client::factory()->create([
            'user_id' => $therapist->id,
            'max_sessions' => 20,
            'special_sessions' => 1,
        ]);

        // Create 5 existing special sessions
        for ($i = 0; $i < 5; $i++) {
            TherapySession::factory()->create([
                'client_id' => $client2->id,
                'user_id' => $therapist->id,
                'attendance' => 'attended',
                'special' => true,
            ]);
        }

        // Reset the notification fake to clear previous calls
        Notification::fake();

        // Add the 6th special session - this SHOULD trigger special session notification
        $response = $this->actingAs($therapist)->post('/session/store', [
            'client_id' => $client2->id,
            'attendance' => 'attended',
            'notes' => 'Sixth special session',
            'created_at' => now(),
        ]);

        $response->assertRedirect();

        // Assert that special session notification was sent
        Notification::assertSentTo($therapist, SpecialSessionsLimitNotification::class);
    }
}
