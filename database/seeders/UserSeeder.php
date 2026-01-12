<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the "No Therapist" placeholder user with ID 200
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

        User::factory()->count(40)->create();
    }
}
