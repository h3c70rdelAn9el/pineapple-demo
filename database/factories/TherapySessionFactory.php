<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TherapySession>
 */
class TherapySessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sessionCost = $this->faker->randomFloat(2, 80, 120);
        $clientContribution = $this->faker->randomFloat(2, 10, 50);
        
        return [
            'client_id' => null, // Will be set when creating with relationships
            'user_id' => null, // Will be set when creating with relationships
            'session_cost' => $sessionCost,
            'client_contribution' => $clientContribution,
            'remaining_client_contribution' => $sessionCost - $clientContribution,
            'attendance' => $this->faker->randomElement(['attended', 'no-show', 'cancelled']),
            'notes' => $this->faker->optional()->sentence(),
            'special' => false,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
