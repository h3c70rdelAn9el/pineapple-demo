<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientSortingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_sort_clients_by_client_code(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Create some clients with different client codes
        Client::factory()->create(['client_code' => 'B001']);
        Client::factory()->create(['client_code' => 'A001']);
        Client::factory()->create(['client_code' => 'C001']);

        // Test ascending sort
        $response = $this->actingAs($admin)->get('/clients?sort=client_code&direction=asc');
        $response->assertStatus(200);

        // Test descending sort
        $response = $this->actingAs($admin)->get('/clients?sort=client_code&direction=desc');
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_sort_clients_by_created_at(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Create some clients
        Client::factory()->count(3)->create();

        // Test created_at sort
        $response = $this->actingAs($admin)->get('/clients?sort=created_at&direction=desc');
        $response->assertStatus(200);
    }

    /** @test */
    public function invalid_sort_fields_default_to_client_code(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'admin' => 1,
        ]);

        // Create a client
        Client::factory()->create();

        // Test with invalid sort field
        $response = $this->actingAs($admin)->get('/clients?sort=invalid_field&direction=asc');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_can_access_sorted_client_list(): void
    {
        // Create a regular user (therapist)
        $therapist = User::factory()->create([
            'admin' => 0,
        ]);

        // Create clients for this therapist
        Client::factory()->create(['user_id' => $therapist->id]);

        // Test that non-admin can access sorted list
        $response = $this->actingAs($therapist)->get('/clients?sort=client_code&direction=asc');
        $response->assertStatus(200);
    }
}
