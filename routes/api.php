<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StressResultController;
use App\Http\Controllers\Api\AuthMobileController;
use App\Http\Controllers\Api\FollowUpController;
use App\Http\Controllers\Api\StudentController;

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

// Master Data
Route::get('/students', [StudentController::class, 'index']);

// Stress Results CRUD
Route::apiResource('stress-results', StressResultController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

// Follow-Ups (Notifikasi Mahasiswa)
Route::get('/follow-ups', [FollowUpController::class, 'index']);
