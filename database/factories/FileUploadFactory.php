<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FileUpload>
 */
class FileUploadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentTypes = [
            'photographic_id',
            'W9',
            'clinical_license',
            'public_liability_insurance',
            'W8BENE',
            'W8BEN',
            'Voided Check',
            'supervisor_approval_letter',
            'headshot',
            'Bio',
            'terms_of_business',
            'Other',
        ];

        return [
            'user_id' => \App\Models\User::factory(),
            'file_path' => 'uploads/forms/therapist/'.fake()->numberBetween(1, 100).'/',
            'file_name' => fake()->uuid().'.'.fake()->randomElement(['pdf', 'jpg', 'png']),
            'file_title' => fake()->sentence(3),
            'document_type' => fake()->randomElement($documentTypes),
            'region' => fake()->randomElement(['US', 'UK', 'CA', null]),
            'date' => fake()->optional()->dateTimeBetween('now', '+2 years'),
            'note' => fake()->optional()->sentence(),
            'verified' => fake()->boolean(70), // 70% chance of being verified
            'pinned' => fake()->boolean(20), // 20% chance of being pinned
        ];
    }
}
