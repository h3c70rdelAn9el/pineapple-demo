<?php

use App\Models\TherapySession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
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

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::post('/patient/store', [PatientController::class, 'store']);
// });



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/patient/store', [PatientController::class, 'store'])->name('patient.store');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/patients', [PatientController::class, 'index'])->name('patients');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/patients/{patient_id}', [PatientController::class, 'show'])->name('patient');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->get('/patient/{id}', [PatientController::class, 'show'])->name('patient.show');
// Route::get('/patients/show/{first}', [PatientController::class, 'show'])->name('patient');
// Route::get('/patients/{patient_id}', [PatientController::class, 'show'])->name('patient');

// Route::post('/patients/{patient_id}/therapy_session/store', 'TherapySessionController@store')->middleware('auth')->name('therapy_session.store');
