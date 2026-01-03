<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ReservasiController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('lapangan', LapanganController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('reservasi', ReservasiController::class);
