<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('login');
});

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('mitra', App\Http\Controllers\MitraController::class)->except('show');

Route::resource('anggaran', App\Http\Controllers\AnggaranController::class)->except('show');

Route::resource('kontrak', App\Http\Controllers\KontrakController::class);
