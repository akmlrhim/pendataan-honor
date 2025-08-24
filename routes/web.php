<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('mitra', App\Http\Controllers\MitraController::class)->except('show');

Route::resource('anggaran', App\Http\Controllers\AnggaranController::class)->except('show');

Route::resource('kontrak', App\Http\Controllers\KontrakController::class);
