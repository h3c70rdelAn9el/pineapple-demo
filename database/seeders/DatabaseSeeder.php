<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\FileUpload;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the "No Therapist" placeholder user exists
        DB::table('users')->insertOrIgnore([
            'id' => 200,
            'name' => '',
            'email' => 'no-therapist-placeholder@pineapplesupport.org',
            'password' => Hash::make('placeholder-no-login'),
            'admin' => 0,
            'active_status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin users
        User::updateOrCreate(
            ['email' => 'tanguy@decourson.com'],
            [
                'name' => 'Tanguy Admin',
                'password' => Hash::make('tanguytanguy'),
                'email_verified_at' => now(),
                'admin' => true,
                'session_cost' => 100,
                'active_status' => true,
            ]
        );

        // Seed demo sessions for niles@example.com
        $this->call(NilesDemoSessionsSeeder::class);

        User::updateOrCreate(
            ['email' => 'daffy@example.com'],
            [
                'name' => 'Daffy Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'admin' => true,
                'session_cost' => 100,
                'active_status' => true,
                'id_uploaded' => true,
                'W9_or_WBEN_uploaded' => true,
                'license_uploaded' => true,
                'headshot_uploaded' => true,
                'bio_uploaded' => true,
                'insurance_uploaded' => true,
            ]
        );

        // Group 1: Active therapists with fully verified profiles (5)
        $verifiedTherapists = User::factory(5)->create([
            'admin' => false,
            'active_status' => true,
            'session_cost' => fake()->randomElement([80, 100, 120, 150]),
            'space_for_new_clients' => fake()->numberBetween(2, 6),
            'id_uploaded' => true,
            'W9_or_WBEN_uploaded' => true,
            'license_uploaded' => true,
            'headshot_uploaded' => true,
            'bio_uploaded' => true,
            'insurance_uploaded' => true,
            'contract_signed' => true,
        ]);
        foreach ($verifiedTherapists as $therapist) {
            $this->createProfileDocuments($therapist, complete: true, verified: true);
            $this->seedClientsForTherapist($therapist, activeCount: rand(4, 8), inactiveCount: rand(1, 3));
        }

        // Group 2: Active therapists with complete but un-verified profiles (3)
        $uploadedNotVerified = User::factory(3)->create([
            'admin' => false,
            'active_status' => true,
            'session_cost' => fake()->randomElement([80, 100, 120]),
            'space_for_new_clients' => fake()->numberBetween(1, 4),
            'id_uploaded' => true,
            'W9_or_WBEN_uploaded' => true,
            'license_uploaded' => true,
            'headshot_uploaded' => true,
            'bio_uploaded' => true,
            'insurance_uploaded' => true,
        ]);
        foreach ($uploadedNotVerified as $therapist) {
            $this->createProfileDocuments($therapist, complete: true, verified: false);
            $this->seedClientsForTherapist($therapist, activeCount: rand(3, 6), inactiveCount: rand(0, 2));
        }

        // Group 3: Active therapists with incomplete profiles (4)
        $incompleteProfile = User::factory(4)->create([
            'admin' => false,
            'active_status' => true,
            'session_cost' => fake()->randomElement([80, 100, 120]),
            'space_for_new_clients' => fake()->numberBetween(0, 3),
            'id_uploaded' => false,
            'W9_or_WBEN_uploaded' => false,
            'license_uploaded' => false,
            'headshot_uploaded' => false,
            'bio_uploaded' => false,
            'insurance_uploaded' => false,
        ]);
        foreach ($incompleteProfile as $therapist) {
            $this->createProfileDocuments($therapist, complete: false, verified: false);
            $this->seedClientsForTherapist($therapist, activeCount: rand(2, 5), inactiveCount: rand(0, 2));
        }

        // Group 4: Inactive therapists (2)
        $inactiveTherapists = User::factory(2)->create([
            'admin' => false,
            'active_status' => false,
            'session_cost' => fake()->randomElement([80, 100]),
            'space_for_new_clients' => 0,
            'id_uploaded' => true,
            'W9_or_WBEN_uploaded' => true,
            'license_uploaded' => true,
            'headshot_uploaded' => true,
            'bio_uploaded' => true,
            'insurance_uploaded' => true,
        ]);
        foreach ($inactiveTherapists as $therapist) {
            $this->createProfileDocuments($therapist, complete: true, verified: true);
            $this->seedClientsForTherapist($therapist, activeCount: 0, inactiveCount: rand(3, 6));
        }

        // Group 5: On-vacation therapist (1)
        $vacationTherapists = User::factory(1)->create([
            'admin' => false,
            'active_status' => true,
            'on_vacation' => true,
            'session_cost' => 100,
            'space_for_new_clients' => 0,
            'id_uploaded' => true,
            'W9_or_WBEN_uploaded' => true,
            'license_uploaded' => true,
            'headshot_uploaded' => true,
            'bio_uploaded' => true,
            'insurance_uploaded' => true,
        ]);
        foreach ($vacationTherapists as $therapist) {
            $this->createProfileDocuments($therapist, complete: true, verified: true);
            $this->seedClientsForTherapist($therapist, activeCount: rand(3, 5), inactiveCount: rand(1, 2));
        }

        // Waitlisted clients with no therapist assigned yet
        Client::factory(6)->create([
            'user_id' => null,
            'status' => 0,
            'waitlist' => 1,
        ]);
    }

    /**
     * Create file_uploads records that back the isComplete() and isVerified() checks.
     *
     * A full profile requires photographic_id, W9, clinical_license, headshot, Bio, and
     * public_liability_insurance. The ones marked needs_expiry must have date > NOW() to
     * pass the model's "uploaded" checks. Incomplete profiles get only 1-3 random docs.
     */
    private function createProfileDocuments(User $therapist, bool $complete, bool $verified): void
    {
        $allDocs = [
            ['type' => 'photographic_id',           'needs_expiry' => true],
            ['type' => 'W9',                         'needs_expiry' => false],
            ['type' => 'clinical_license',           'needs_expiry' => true],
            ['type' => 'headshot',                   'needs_expiry' => false],
            ['type' => 'Bio',                        'needs_expiry' => false],
            ['type' => 'public_liability_insurance', 'needs_expiry' => true],
        ];

        $docsToCreate = $complete
            ? $allDocs
            : collect($allDocs)->random(rand(1, 3))->values()->toArray();

        foreach ($docsToCreate as $doc) {
            FileUpload::create([
                'user_id'       => $therapist->id,
                'file_path'     => 'uploads/forms/therapist/' . $therapist->id . '/',
                'file_name'     => fake()->uuid() . '.pdf',
                'file_title'    => $doc['type'],
                'document_type' => $doc['type'],
                'region'        => fake()->randomElement(['US', 'UK']),
                'date'          => $doc['needs_expiry'] ? now()->addYears(rand(1, 2)) : null,
                'note'          => null,
                'verified'      => $verified,
                'pinned'        => false,
            ]);
        }
    }

    /**
     * Create active and inactive clients for a therapist, each with therapy sessions.
     */
    private function seedClientsForTherapist(User $therapist, int $activeCount, int $inactiveCount): void
    {
        $sessionCost = $therapist->session_cost ?? 100;

        if ($activeCount > 0) {
            $activeClients = Client::factory($activeCount)->create([
                'user_id'             => $therapist->id,
                'status'              => 0,
                'waitlist'            => 0,
                'cost_per_session'    => $sessionCost,
                'client_contribution' => fake()->randomFloat(2, 10, min(50, $sessionCost)),
            ]);

            foreach ($activeClients as $client) {
                $this->seedSessionsForClient($client, $therapist, count: rand(3, 8));
            }
        }

        if ($inactiveCount > 0) {
            $inactiveClients = Client::factory($inactiveCount)->create([
                'user_id'             => $therapist->id,
                'status'              => 1,
                'waitlist'            => 0,
                'cost_per_session'    => $sessionCost,
                'client_contribution' => fake()->randomFloat(2, 10, min(50, $sessionCost)),
            ]);

            foreach ($inactiveClients as $client) {
                $this->seedSessionsForClient($client, $therapist, count: rand(2, 5));
            }
        }
    }

    /**
     * Create therapy sessions with proper cost/contribution breakdown.
     */
    private function seedSessionsForClient(Client $client, User $therapist, int $count): void
    {
        $sessionCost   = $therapist->session_cost ?? 100;
        $clientContrib = $client->client_contribution ?? fake()->randomFloat(2, 10, 50);

        for ($i = 0; $i < $count; $i++) {
            TherapySession::create([
                'client_id'                     => $client->id,
                'user_id'                       => $therapist->id,
                'session_cost'                  => $sessionCost,
                'client_contribution'           => $clientContrib,
                'remaining_client_contribution' => max(0, $sessionCost - $clientContrib),
                'attendance'                    => fake()->randomElement(['attended', 'attended', 'attended', 'no-show', 'cancelled']),
                'notes'                         => fake()->optional(0.3)->sentence(),
                'special'                       => false,
                'created_at'                    => fake()->dateTimeBetween('-12 months', 'now'),
                'updated_at'                    => now(),
            ]);
        }
    }
}
