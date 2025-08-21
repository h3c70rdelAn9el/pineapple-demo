<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_code' => 'CLIENT'.$this->faker->unique()->numberBetween(1000, 9999),
            'preferred_name' => $this->faker->firstName(),
            'legal_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'contact_method' => $this->faker->randomElement(['email', 'phone', 'text']),
            'status' => 0, // active
            'max_sessions' => $this->faker->numberBetween(8, 16),
            'client_contribution' => $this->faker->randomFloat(2, 10, 50),
            'user_id' => null, // Will be set when creating with relationships
            'waitlist' => 0,
            'special_sessions' => 0,
            'category' => $this->faker->randomElement(['Active', 'Active - with intern', 'Corporate']),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Non-binary', 'Prefer not to say']),
            'pronouns' => $this->faker->randomElement(['he/him', 'she/her', 'they/them']),
            'sexual_orientation' => $this->faker->randomElement(['Heterosexual', 'Gay', 'Lesbian', 'Bisexual', 'Pansexual', 'Prefer not to say']),
            'ethnic_group' => $this->faker->randomElement(['White', 'Black or African American', 'Asian', 'Hispanic or Latino', 'Native American', 'Other']),
            'home_address_state' => $this->faker->state(),
            'home_address_country' => $this->faker->country(),
            'previous_therapy' => $this->faker->boolean(),
            'preferred_language' => 'English',
            'additional_notes' => $this->faker->optional()->sentence(),
            'has_been_contacted' => false,
        ];
    }
}
