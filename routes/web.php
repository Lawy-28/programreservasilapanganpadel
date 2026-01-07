<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('lapangan', LapanganController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('reservasi', ReservasiController::class);

use App\Http\Controllers\PlaygroundController;
Route::get('/playground', [PlaygroundController::class, 'index'])->name('playground');
