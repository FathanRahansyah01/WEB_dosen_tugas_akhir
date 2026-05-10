<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AdminController;

// ==========================================
// REDIRECT ROOT
// ==========================================
Route::get('/', function () {
    return redirect('/login');
});

// ==========================================
// AUTH ROUTES (GUEST ONLY)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// DOSEN ROUTES
// ==========================================
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])->name('mahasiswa');
    Route::get('/mahasiswa/{student}', [DosenController::class, 'detailMahasiswa'])->name('mahasiswa.detail');
    Route::get('/monitoring', [DosenController::class, 'monitoring'])->name('monitoring');
    Route::get('/risiko', [DosenController::class, 'risikoTinggi'])->name('risiko');

    // Tindak Lanjut (CRUD)
    Route::get('/tindak-lanjut', [DosenController::class, 'tindakLanjut'])->name('tindak-lanjut.index');
    Route::get('/tindak-lanjut/create', [DosenController::class, 'createTindakLanjut'])->name('tindak-lanjut.create');
    Route::post('/tindak-lanjut', [DosenController::class, 'storeTindakLanjut'])->name('tindak-lanjut.store');
    Route::get('/tindak-lanjut/{followUp}/edit', [DosenController::class, 'editTindakLanjut'])->name('tindak-lanjut.edit');
    Route::put('/tindak-lanjut/{followUp}', [DosenController::class, 'updateTindakLanjut'])->name('tindak-lanjut.update');
    Route::delete('/tindak-lanjut/{followUp}', [DosenController::class, 'destroyTindakLanjut'])->name('tindak-lanjut.destroy');
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Mahasiswa
    Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('mahasiswa.index');
    Route::get('/mahasiswa/create', [AdminController::class, 'mahasiswaCreate'])->name('mahasiswa.create');
    Route::post('/mahasiswa', [AdminController::class, 'mahasiswaStore'])->name('mahasiswa.store');
    Route::get('/mahasiswa/{student}/edit', [AdminController::class, 'mahasiswaEdit'])->name('mahasiswa.edit');
    Route::put('/mahasiswa/{student}', [AdminController::class, 'mahasiswaUpdate'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{student}', [AdminController::class, 'mahasiswaDestroy'])->name('mahasiswa.destroy');

    // CRUD Dosen
    Route::get('/dosen', [AdminController::class, 'dosenIndex'])->name('dosen.index');
    Route::get('/dosen/create', [AdminController::class, 'dosenCreate'])->name('dosen.create');
    Route::post('/dosen', [AdminController::class, 'dosenStore'])->name('dosen.store');
    Route::get('/dosen/{user}/edit', [AdminController::class, 'dosenEdit'])->name('dosen.edit');
    Route::put('/dosen/{user}', [AdminController::class, 'dosenUpdate'])->name('dosen.update');
    Route::delete('/dosen/{user}', [AdminController::class, 'dosenDestroy'])->name('dosen.destroy');
});
