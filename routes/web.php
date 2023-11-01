<?php

use App\Models\TherapySession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\TherapistsController;
use App\Http\Controllers\TherapySessionController;

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
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->post('/client/store', [ClientController::class, 'store'])->name('client.store');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->post('/session/store', [TherapySessionController::class, 'store'])->name('session.store');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->get('/session/{id}', [TherapySessionController::class, 'show'])->name('session.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::post('/session/store', [TherapySessionController::class, 'store'])->name('session.store');
    Route::get('/session/{id}', [TherapySessionController::class, 'show'])->name('session.show');
    Route::get('file-upload', [FileUploadController::class, 'index'])->name('fileUpload');
    Route::post('file-store', [FileUploadController::class, 'store'])->name('fileStore');
    // Route::put('file-update/{id}', [FileUploadController::class, 'update'])->name('fileUpdate');
    // Route::put('file-update/{id}', 'App\Http\Controllers\FileUploadController@update')->name('fileUpdate');
    // Route::get('file-edit/{id}', [FileUploadController::class, 'edit'])->name('fileEdit');

    Route::put('/profile/update', [UserController::class, 'updateUserProfile'])->name('profile.update');
    // Route::post('/update-gender', 'UserController@updateGender')->name('update.gender');
    Route::post('update-gender', [UserController::class, 'updateGender'])->name('update.gender');

    Route::get('/therapist/{id}/forms/', [FileUploadController::class, 'index'])->name('therapist.forms');
    Route::get('/therapist/forms/{therapist}', [FileUploadController::class, 'index'])->name('therapist.forms');

    Route::get('/therapist/{id}/edit', [TherapistsController::class, 'edit'])->name('therapist.edit');
    Route::put('/therapist/{id}/update', [TherapistsController::class, 'update'])->name('therapist.update');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::get('/clients/{client_id}', [ClientController::class, 'show'])->name('clients.show');
    Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client_id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client_id}/update', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/search', SearchController::class)->name('search');
    Route::get('/file-upload/search/{therapist}', [FileUploadController::class, 'search'])->name('file-upload.search');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->put('/therapist/forms/{id}/update', [FileUploadController::class, 'update'])->name('fileUpdate');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/therapist/forms/{id}/edit', [FileUploadController::class, 'edit'])->name('fileEdit');


// Route::get('/therapist/forms/{therapist}/edit', [FileUploadController::class, 'edit'])->name('therapist.forms.edit');
// Route::put('/therapist/forms/{therapist}/update', [FileUploadController::class, 'update'])->name('therapist.forms.update');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->get('/patient/{id}', [PatientController::class, 'show'])->name('patient.show');
// Route::get('/patients/show/{first}', [PatientController::class, 'show'])->name('patient');
// Route::get('/patients/{patient_id}', [PatientController::class, 'show'])->name('patient');

// Route::post('/patients/{patient_id}/therapy_session/store', 'TherapySessionController@store')->middleware('auth')->name('therapy_session.store');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/therapists', [TherapistsController::class, 'index'])->name('therapists.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/therapist/{id}', [TherapistsController::class, 'show'])->name('therapist.show');
