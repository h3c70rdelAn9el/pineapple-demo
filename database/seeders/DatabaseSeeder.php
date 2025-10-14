<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
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

        // Create therapist user (who can have clients)
        $therapist = User::updateOrCreate(
            ['email' => 'tanguy+client@decourson.com'],
            [
                'name' => 'Tanguy Therapist',
                'password' => Hash::make('tanguytanguy'),
                'email_verified_at' => now(),
                'admin' => false,
                'session_cost' => 100,
                'active_status' => true,
                'space_for_new_clients' => true,
            ]
        );

        // Create additional therapists
        $therapists = User::factory(5)->create([
            'admin' => false,
            'active_status' => true,
            'session_cost' => 100,
        ]);

        // Add the main therapist to the collection
        $allTherapists = collect([$therapist])->merge($therapists);

        // Create clients for the main therapist (tanguy+client@decourson.com)
        $therapistClients = Client::factory(8)->create([
            'user_id' => $therapist->id,
            'status' => 0, // active
        ]);

        // Create therapy sessions for the main therapist's clients
        foreach ($therapistClients as $client) {
            TherapySession::factory(rand(2, 6))->create([
                'client_id' => $client->id,
                'user_id' => $therapist->id,
                'session_cost' => $therapist->session_cost,
            ]);
        }

        // Create clients for other therapists
        foreach ($therapists as $otherTherapist) {
            $clients = Client::factory(rand(3, 8))->create([
                'user_id' => $otherTherapist->id,
                'status' => 0,
            ]);

            // Create therapy sessions for each client
            foreach ($clients as $client) {
                TherapySession::factory(rand(2, 5))->create([
                    'client_id' => $client->id,
                    'user_id' => $otherTherapist->id,
                    'session_cost' => $otherTherapist->session_cost,
                ]);
            }
        }

        // Create some waitlist clients (no therapist assigned yet)
        Client::factory(5)->create([
            'user_id' => $therapists->random()->id, // Assign to random therapist but mark as waitlist
            'status' => 0,
            'waitlist' => 1,
        ]);
    }
}
