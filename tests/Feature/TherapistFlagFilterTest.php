<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TherapistFlagFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_therapists_index_includes_flag_filter_data(): void
    {
        // Create an admin user
        $admin = User::factory()->create(['admin' => 1]);

        // Act as the admin and visit therapists index
        $response = $this->actingAs($admin)->get(route('therapists.index'));

        // Assert the response is successful and contains the flag filter data
        $response->assertStatus(200);
        $response->assertViewHas('flagFilteredTherapists');
        $response->assertViewHas('selectedFlag');
    }

    public function test_out_of_state_coaching_filter_returns_correct_therapists(): void
    {
        // Create an admin user
        $admin = User::factory()->create(['admin' => 1]);

        // Create therapists with out_of_state_coaching flag set to 1
        $therapistWithFlag = User::factory()->create([
            'admin' => 0,
            'out_of_state_coaching' => '1',
            'name' => 'John Doe',
        ]);

        // Create therapist without the flag
        $therapistWithoutFlag = User::factory()->create([
            'admin' => 0,
            'out_of_state_coaching' => '0',
            'name' => 'Jane Smith',
        ]);

        // Act as the admin and visit therapists index with flag filter
        $response = $this->actingAs($admin)->get(route('therapists.index', ['flag_filter' => 'out_of_state_coaching']));

        // Assert the response is successful
        $response->assertStatus(200);
        $response->assertViewHas('flagFilteredTherapists');
        $response->assertViewHas('selectedFlag', 'out_of_state_coaching');

        // Get the filtered therapists from the view
        $flagFilteredTherapists = $response->viewData('flagFilteredTherapists');

        // Assert that the filtered collection contains the therapist with flag
        $this->assertTrue($flagFilteredTherapists->contains('id', $therapistWithFlag->id));

        // Assert that the filtered collection does not contain therapist without flag
        $this->assertFalse($flagFilteredTherapists->contains('id', $therapistWithoutFlag->id));
    }

    public function test_contact_for_promotionals_filter_returns_correct_therapists(): void
    {
        // Create an admin user
        $admin = User::factory()->create(['admin' => 1]);

        // Create therapists with contact_for_promotionals flag set to true
        $therapistWithFlag = User::factory()->create([
            'admin' => 0,
            'contact_for_promotionals' => 1,
        ]);

        // Create therapist without the flag
        $therapistWithoutFlag = User::factory()->create([
            'admin' => 0,
            'contact_for_promotionals' => 0,
        ]);

        // Act as the admin and visit therapists index with flag filter
        $response = $this->actingAs($admin)->get(route('therapists.index', ['flag_filter' => 'contact_for_promotionals']));

        // Assert the response is successful
        $response->assertStatus(200);

        // Get the filtered therapists from the view
        $flagFilteredTherapists = $response->viewData('flagFilteredTherapists');

        // Assert that the filtered collection contains the therapist with flag
        $this->assertTrue($flagFilteredTherapists->contains('id', $therapistWithFlag->id));

        // Assert that the filtered collection does not contain therapist without flag
        $this->assertFalse($flagFilteredTherapists->contains('id', $therapistWithoutFlag->id));
    }

    public function test_intern_filter_returns_correct_therapists(): void
    {
        // Create an admin user
        $admin = User::factory()->create(['admin' => 1]);

        // Create therapists with intern flag set to true
        $therapistWithFlag = User::factory()->create([
            'admin' => 0,
            'intern' => 1,
        ]);

        // Create therapist without the flag
        $therapistWithoutFlag = User::factory()->create([
            'admin' => 0,
            'intern' => 0,
        ]);

        // Act as the admin and visit therapists index with flag filter
        $response = $this->actingAs($admin)->get(route('therapists.index', ['flag_filter' => 'intern']));

        // Assert the response is successful
        $response->assertStatus(200);

        // Get the filtered therapists from the view
        $flagFilteredTherapists = $response->viewData('flagFilteredTherapists');

        // Assert that the filtered collection contains the therapist with flag
        $this->assertTrue($flagFilteredTherapists->contains('id', $therapistWithFlag->id));

        // Assert that the filtered collection does not contain therapist without flag
        $this->assertFalse($flagFilteredTherapists->contains('id', $therapistWithoutFlag->id));
    }
}
