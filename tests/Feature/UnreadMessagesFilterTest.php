<?php

namespace Tests\Feature;

use App\Models\ChMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnreadMessagesFilterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function user_can_view_all_messages_by_default()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Create some messages
        ChMessage::factory()->create([
            'from_id' => $otherUser->id,
            'to_id' => $user->id,
            'body' => 'Test message 1',
            'seen' => false,
        ]);

        ChMessage::factory()->create([
            'from_id' => $otherUser->id,
            'to_id' => $user->id,
            'body' => 'Test message 2',
            'seen' => true,
        ]);

        $response = $this->actingAs($user)->get('/messages/getContacts');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'contacts',
            'total',
            'last_page',
        ]);
    }

    /** @test */
    public function user_can_view_only_unread_messages()
    {
        $user = User::factory()->create();
        $otherUser1 = User::factory()->create();
        $otherUser2 = User::factory()->create();

        // Create an unread message from otherUser1
        ChMessage::factory()->create([
            'from_id' => $otherUser1->id,
            'to_id' => $user->id,
            'body' => 'Unread message',
            'seen' => false,
        ]);

        // Create a read message from otherUser2
        ChMessage::factory()->create([
            'from_id' => $otherUser2->id,
            'to_id' => $user->id,
            'body' => 'Read message',
            'seen' => true,
        ]);

        $response = $this->actingAs($user)->get('/messages/getContacts?filter=unread');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'contacts',
            'total',
            'last_page',
        ]);

        // The response should only include contacts with unread messages
        $this->assertEquals(1, $response->json('total'));
    }

    /** @test */
    public function unread_contacts_endpoint_returns_empty_when_no_unread_messages()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Create only read messages
        ChMessage::factory()->create([
            'from_id' => $otherUser->id,
            'to_id' => $user->id,
            'body' => 'Read message',
            'seen' => true,
        ]);

        $response = $this->actingAs($user)->get('/messages/getContacts?filter=unread');

        $response->assertStatus(200);
        $this->assertEquals(0, $response->json('total'));
        $this->assertStringContainsString('No unread messages', $response->json('contacts'));
    }

    /** @test */
    public function messages_page_displays_filter_buttons()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/messages');

        $response->assertStatus(200);
        $response->assertSee('All Messages');
        $response->assertSee('Unread Only');
        $response->assertSee('filter-btn');
    }
}