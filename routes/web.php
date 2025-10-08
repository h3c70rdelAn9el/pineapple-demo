<?php

use App\Http\Controllers\AdminBroadcastController;
use App\Http\Controllers\AdminEmailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TherapistsController;
use App\Http\Controllers\TherapySessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->post('/client/store', [ClientController::class, 'store'])->name('client.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->post('/session/store', [TherapySessionController::class, 'store'])->name('session.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::post('/session/store', [TherapySessionController::class, 'store'])->name('session.store');
    Route::get('/session/{id}', [TherapySessionController::class, 'show'])->name('session.show');
    Route::get('sessions/index', [TherapySessionController::class, 'index'])->name('session.index');
    Route::patch('/sessions/{therapySession}', [TherapySessionController::class, 'update'])->name('session.update');
    Route::delete('/sessions/{therapySession}', [TherapySessionController::class, 'destroy'])->name('session.destroy');
    Route::get('file-upload', [FileUploadController::class, 'index'])->name('fileUpload');
    Route::post('file-store/{id}', [FileUploadController::class, 'store'])->name('fileStore');

    Route::put('/profile/update', [UserController::class, 'updateUserProfile'])->name('profile.update');
    // Route::post('/update-gender', 'UserController@updateGender')->name('update.gender');
    Route::post('update-gender', [UserController::class, 'updateGender'])->name('update.gender');
    Route::get('/therapists', [TherapistsController::class, 'index'])->name('therapists.index');
    Route::get('/therapist/{id}/forms/', [FileUploadController::class, 'index'])->name('therapist.forms');
    Route::get('/therapist/forms/{therapist}', [FileUploadController::class, 'index'])->name('therapist.forms');

    Route::get('/therapist/{id}/edit', [TherapistsController::class, 'edit'])->name('therapist.edit');
    Route::put('/therapist/{id}/update', [TherapistsController::class, 'update'])->name('therapist.update');
    Route::post('/therapist/{id}/send-invoice', [TherapistsController::class, 'sendLastMonthInvoice'])->name('therapist.send-invoice');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::get('/clients/{client_id}', [ClientController::class, 'show'])->name('clients.show');
    Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client_id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    // Route::put('/clients/{client}/update', [ClientController::class, 'update'])->name('clients.update');
    // HAD TO USE POST METHOD INSTEAD OF PUT FOR THIS ROUTE
    Route::post('/clients/{client}/update', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client_id}/delete', [ClientController::class, 'destroy'])->name('clients.delete');
    Route::get('/search', SearchController::class)->name('search');
    Route::get('/file-upload/search/{therapist}', [FileUploadController::class, 'search'])->name('file-upload.search');
    Route::get('/maintenance', function () {
        return response()->view('errors.503', [], 503);
    });

    Route::delete('/therapist/{id}', [TherapistsController::class, 'destroy'])->name('therapist.destroy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->put('/therapist/forms/{id}/update', [FileUploadController::class, 'update'])->name('fileUpdate');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/therapist/forms/{id}/edit', [FileUploadController::class, 'edit'])->name('fileEdit');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->delete('/therapist/forms/{id}', [FileUploadController::class, 'destroy'])->name('fileDelete');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/therapists', [TherapistsController::class, 'index'])->name('therapists.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/therapist/{id}', [TherapistsController::class, 'show'])->name('therapist.show');

// Admin email routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin/email-therapists', [AdminEmailController::class, 'index'])->name('admin.email-therapists');
    Route::post('/admin/email-therapists/send', [AdminEmailController::class, 'send'])->name('admin.email-therapists.send');
});

// Admin broadcast message routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin/broadcast-message', [AdminBroadcastController::class, 'index'])->name('admin.broadcast-message');
    Route::post('/admin/broadcast-message/send', [AdminBroadcastController::class, 'send'])->name('admin.broadcast-message.send');
    Route::get('/admin/broadcast-history', [AdminBroadcastController::class, 'history'])->name('admin.broadcast-history');
});

// Email preview route (for development/testing)
Route::get('/preview-w9-email', function () {
    $user = new \App\Models\User([
        'name' => 'Dr. Jane Smith',
        'preferred_name' => 'Jane',
        'email' => 'jane.smith@example.com',
        'street_address' => '123 New Therapy Lane',
        'county_town' => 'Mental Health City',
        'state' => 'CA',
        'zip_code_postal_code' => '90210',
        'country' => 'United States',
    ]);

    return (new \App\Mail\TherapistAddressUpdatedW9Reminder($user))->render();
})->name('preview.w9.email');
