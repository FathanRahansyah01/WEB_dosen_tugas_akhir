<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StressResultController;
use App\Http\Controllers\Api\AuthMobileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Endpoint untuk integrasi Flutter Mobile → Laravel Backend.
| Semua route di sini otomatis memiliki prefix /api
|
*/

// Auth Mobile (Mahasiswa)
Route::post('/register', [AuthMobileController::class, 'register']);
Route::post('/login', [AuthMobileController::class, 'login']);

// Stress Results CRUD
Route::apiResource('stress-results', StressResultController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);
