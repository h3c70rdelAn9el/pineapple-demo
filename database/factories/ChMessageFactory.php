<?php

namespace Database\Factories;

use App\Models\ChMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChMessage>
 */
class ChMessageFactory extends Factory
{
    protected $model = ChMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_id' => User::factory(),
            'to_id' => User::factory(),
            'body' => $this->faker->sentence(),
            'attachment' => null,
            'seen' => $this->faker->boolean(),
        ];
    }

    public function unread(): Factory
    {
        return $this->state([
            'seen' => false,
        ]);
    }

    public function read(): Factory
    {
        return $this->state([
            'seen' => true,
        ]);
    }
}
