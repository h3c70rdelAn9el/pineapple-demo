<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientContactedFieldTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that a client can be created with has_been_contacted field.
     */
    public function test_client_can_be_created_with_contacted_field(): void
    {
        $client = Client::factory()->create([
            'has_been_contacted' => true,
        ]);

        $this->assertTrue($client->has_been_contacted);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'has_been_contacted' => 1,
        ]);
    }

    /**
     * Test that a client can be updated with has_been_contacted field.
     */
    public function test_client_can_be_updated_with_contacted_field(): void
    {
        $admin = User::factory()->create(['admin' => 1]);
        $client = Client::factory()->create([
            'has_been_contacted' => false,
        ]);

        $this->actingAs($admin)
            ->put(route('clients.update', $client), [
                'client_code' => $client->client_code,
                'preferred_name' => $client->preferred_name,
                'has_been_contacted' => 1,
            ]);

        $client->refresh();
        $this->assertTrue($client->has_been_contacted);
    }

    /**
     * Test that has_been_contacted defaults to false for new clients.
     */
    public function test_has_been_contacted_defaults_to_false(): void
    {
        $client = Client::factory()->create();

        $this->assertFalse($client->has_been_contacted);
    }
}
