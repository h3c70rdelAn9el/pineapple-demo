<?php

use App\Http\Controllers\Api\AdminEmailController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TherapistController;
use App\Http\Controllers\Api\TherapySessionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth routes (Sanctum SPA)
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('web');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware(['web', 'auth:sanctum']);

// Protected routes
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    // Auth
    Route::get('/user', [AuthController::class, 'user']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Clients
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/create', [ClientController::class, 'create']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::put('/clients/{client}', [ClientController::class, 'update']);
    Route::delete('/clients/{client}', [ClientController::class, 'destroy']);

    // Therapy Sessions
    Route::get('/sessions', [TherapySessionController::class, 'index']);
    Route::post('/sessions', [TherapySessionController::class, 'store']);
    Route::get('/sessions/{id}', [TherapySessionController::class, 'show']);
    Route::patch('/sessions/{therapySession}', [TherapySessionController::class, 'update']);
    Route::delete('/sessions/{therapySession}', [TherapySessionController::class, 'destroy']);

    // Therapists
    Route::get('/therapists', [TherapistController::class, 'index']);
    Route::get('/therapists/{id}', [TherapistController::class, 'show']);
    Route::get('/therapists/{id}/edit', [TherapistController::class, 'edit']);
    Route::put('/therapists/{id}', [TherapistController::class, 'update']);
    Route::delete('/therapists/{id}', [TherapistController::class, 'destroy']);
    Route::post('/therapists/{id}/send-invoice', [TherapistController::class, 'sendInvoice']);

    // User Profile
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/gender', [UserController::class, 'updateGender']);

    // Admin
    Route::post('/admin/email-therapists', [AdminEmailController::class, 'send']);
    Route::get('/admin/stats', [StatsController::class, 'index']);
});
