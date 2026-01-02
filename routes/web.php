<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('lapangan', LapanganController::class);
