<?php

use App\Mail\TherapistAddressUpdatedW9Reminder;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/preview-email', function () {
    // Create a sample user for preview
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

    $mailable = new TherapistAddressUpdatedW9Reminder($user);

    return $mailable->render();
})->name('preview.email');
