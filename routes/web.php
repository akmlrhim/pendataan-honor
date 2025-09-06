<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {
	Route::get('/', function () {
		return view('login');
	});

	Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

	Route::middleware('auth')->group(function () {
		Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

		Route::resource('mitra', App\Http\Controllers\MitraController::class)->except('show');

		Route::resource('anggaran', App\Http\Controllers\AnggaranController::class)->except('show');

		Route::resource('kontrak', App\Http\Controllers\KontrakController::class);
		Route::get('kontrak/{id}/file', [App\Http\Controllers\KontrakController::class, 'fileKontrak'])->name('kontrak.file');

		Route::resource('user', App\Http\Controllers\UserController::class)->except('show');

		Route::get('profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil.index');
		Route::patch('profil-info', [App\Http\Controllers\ProfilController::class, 'info'])->name('profil.info');
		Route::patch('profil-pwd', [App\Http\Controllers\ProfilController::class, 'password'])->name('profil.pwd');
	});
});
