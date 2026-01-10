<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaygroundController;

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Accessible by Admin and Staff
    Route::middleware(['role:staff'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('reservasi', ReservasiController::class);
    });

    // Accessible only by Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('lapangan', LapanganController::class);
        
        // Playground or other admin-only routes if any
        Route::get('/playground', [PlaygroundController::class, 'index'])->name('playground');
    });
});
