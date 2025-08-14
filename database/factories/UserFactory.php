<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'license' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'certificate' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'expires_at' => $this->faker->date(),
            'account_name' => $this->faker->company(),
            'account_number' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'routing_number' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'on_vacation' => $this->faker->boolean(),
            'clinical_license_verification_portal' => $this->faker->url(),
            'title' => $this->faker->title(),
            'preferred_name' => $this->faker->name(),
            'intern' => $this->faker->boolean(),
            // 'admin' => $this->faker->boolean(),
            'supervisor_name' => $this->faker->name(),
            'street_address' => $this->faker->streetAddress(),
            'zip_code_postal_code' => $this->faker->postcode(),
            'iban_swift_code' => $this->faker->iban(),
            'contract_signed' => $this->faker->boolean(),
            'full' => $this->faker->boolean(),
            'session_cost' => $this->faker->numberBetween($min = 000, $max = 100),
            'contact_for_promotionals' => $this->faker->boolean(),
            'number_of_potential_clients' => $this->faker->numberBetween($min = 000, $max = 100),
            'out_of_state_coaching' => $this->faker->boolean(),
            // 'file_uploads' => $this->faker->file(),
            'w9' => $this->faker->boolean(),
            'headshot' => $this->faker->boolean(),
            'voided_cheque' => $this->faker->boolean(),
            'bio' => $this->faker->boolean(),
            'website' => $this->faker->boolean(),
            'quickbooks' => $this->faker->boolean(),
            'dropbox' => $this->faker->boolean(),
            'client_extensions' => $this->faker->numberBetween($min = 00, $max = 50),
            'notes' => $this->faker->text($maxNbChars = 200),
            'insurance' => $this->faker->boolean(),
            'signed_documents' => $this->faker->boolean(),
            'leah_signed' => $this->faker->boolean(),
            'space_for_new_clients' => $this->faker->numberBetween($min = 00, $max = 50),
            'admin' => $this->faker->boolean(),
            'county_town' => $this->faker->city(),
            'country' => $this->faker->country(),
            'state' => $this->faker->state(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'time_zone' => $this->faker->timezone(),
            'currency' => $this->faker->currencyCode(),
            'active_status' => $this->faker->boolean(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
