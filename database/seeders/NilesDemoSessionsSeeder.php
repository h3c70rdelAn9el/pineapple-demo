<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilesDemoSessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'niles@example.com')->first();
        if (!$user) return;

        $clients = \App\Models\Client::where('user_id', $user->id)->get();
        foreach ($clients as $client) {
            \App\Models\TherapySession::factory(2)->create([
                'user_id' => $user->id,
                'client_id' => $client->id,
            ]);
        }
    }
}
