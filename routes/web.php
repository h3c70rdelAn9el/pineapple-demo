<?php

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| The frontend is served by the Next.js app (localhost:3000).
| Laravel is API-only. All web requests redirect to the frontend.
|--------------------------------------------------------------------------
*/

// Keep the email preview route for development
Route::get('/preview-w9-email', function () {
    $user = new User([
        'name' => 'Dr. Jane Smith',
        'preferred_name' => 'Jane',
        'email' => 'jane.smith@example.com',
        'street_address' => '123 New Therapy Lane',
        'county_town' => 'Mental Health City',
        'state' => 'CA',
        'zip_code_postal_code' => '90210',
        'country' => 'United States',
    ]);

    return (new TherapistAddressUpdatedW9Reminder($user))->render();
})->name('preview.w9.email');
