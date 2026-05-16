<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StressResultController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Endpoint untuk integrasi Flutter Mobile → Laravel Backend.
| Semua route di sini otomatis memiliki prefix /api
|
*/

Route::apiResource('stress-results', StressResultController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);
