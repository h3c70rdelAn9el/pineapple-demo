<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_categories_include_support_groups_and_well_being(): void
    {
        $categories = Client::$categories;

        $this->assertContains('Support Groups', $categories);
        $this->assertContains('Well Being', $categories);
    }

    public function test_all_expected_categories_are_present(): void
    {
        $expectedCategories = [
            'Active',
            'Active - with intern',
            'Corporate',
            'Latin America',
            'Romanian clients',
            'Support Groups',
            'Well Being',
        ];

        $categories = Client::$categories;

        foreach ($expectedCategories as $expectedCategory) {
            $this->assertContains($expectedCategory, $categories);
        }
    }

    public function test_client_can_be_created_with_support_groups_category(): void
    {
        $client = Client::factory()->create([
            'category' => 'Support Groups',
        ]);

        $this->assertEquals('Support Groups', $client->category);
    }

    public function test_client_can_be_created_with_well_being_category(): void
    {
        $client = Client::factory()->create([
            'category' => 'Well Being',
        ]);

        $this->assertEquals('Well Being', $client->category);
    }
}
