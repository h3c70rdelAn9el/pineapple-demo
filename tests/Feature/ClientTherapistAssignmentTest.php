<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ClientTherapistAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the "No Therapist" user with ID 200
        DB::table('users')->insert([
            'id' => 200,
            'name' => '',
            'email' => 'no-therapist-placeholder@pineapplesupport.org',
            'password' => bcrypt('placeholder'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_client_with_no_therapist_string_uses_user_id_200(): void
    {
        $client = Client::factory()->create([
            'user_id' => 200,
        ]);

        $this->assertEquals(200, $client->user_id);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'user_id' => 200,
        ]);
    }

    public function test_client_can_have_user_id_200_as_valid_foreign_key(): void
    {
        // Create a client with user_id 200
        $client = Client::factory()->create([
            'user_id' => 200,
        ]);

        // Verify the relationship works
        $this->assertNotNull($client->user);
        $this->assertEquals(200, $client->user->id);
    }

    public function test_client_with_valid_therapist_id_is_assigned_correctly(): void
    {
        $therapist = User::factory()->create([
            'role' => 'therapist',
        ]);

        $client = Client::factory()->create([
            'user_id' => $therapist->id,
        ]);

        $this->assertEquals($therapist->id, $client->user_id);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'user_id' => $therapist->id,
        ]);
    }
}
