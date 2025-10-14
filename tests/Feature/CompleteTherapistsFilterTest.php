<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompleteTherapistsFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_therapists_index_includes_complete_therapists(): void
    {
        // Create an admin user
        $admin = User::factory()->create(['admin' => 1]);

        // Act as the admin and visit therapists index
        $response = $this->actingAs($admin)->get(route('therapists.index'));

        // Assert the response is successful and contains the complete therapists data
        $response->assertStatus(200);
        $response->assertViewHas('completeTherapists');
    }

    public function test_admin_dashboard_includes_complete_therapists_count(): void
    {
        // Create an admin user
        $admin = User::factory()->create(['admin' => 1]);

        // Act as the admin and visit dashboard
        $response = $this->actingAs($admin)->get(route('dashboard'));

        // Assert the response is successful and contains the complete therapists count
        $response->assertStatus(200);
        $response->assertViewHas('completeTherapistsCount');
        $response->assertViewHas('completeTherapists');
    }
}
