<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function () {

	Route::get('/', function () {
		return redirect()->route('home');
	});

	Route::get('/login', function () {
		return view('login');
	});

	Route::post('/login', [AuthController::class, 'login'])->name('login');

	Route::middleware('auth')->group(function () {
		Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

		Route::get('/home', [HomeController::class, 'index'])->name('home');

		Route::get('mitra', [MitraController::class, 'index'])->name('mitra.index');
		Route::resource('mitra', MitraController::class)
			->except(['index', 'show'])
			->middleware('role:ketua_tim,umum');

		Route::get('anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
		Route::resource('anggaran', AnggaranController::class)
			->except(['index', 'show'])
			->middleware('role:ketua_tim,umum');

		Route::get('anggaran/alokasi/{id}', [AnggaranController::class, 'editAnggaran'])->name('alocate.anggaran');
		Route::put('anggaran/alokasi/{id}', [AnggaranController::class, 'alocateAnggaran'])->name('store.alocate.anggaran');

		Route::middleware('role:ketua_tim,umum')->group(function () {
			Route::get('kontrak/create', [KontrakController::class, 'create'])->name('kontrak.create');
			Route::post('kontrak', [KontrakController::class, 'store'])->name('kontrak.store');
			Route::get('kontrak/{kontrak}/edit', [KontrakController::class, 'edit'])->name('kontrak.edit');
			Route::put('kontrak/{kontrak}', [KontrakController::class, 'update'])->name('kontrak.update');
			Route::delete('kontrak/{kontrak}', [KontrakController::class, 'destroy'])->name('kontrak.destroy');
		});

		Route::resource('kontrak', KontrakController::class)->only(['index', 'show']);

		Route::get('kontrak/{id}/file', [KontrakController::class, 'fileKontrak'])->name('kontrak.file')->middleware('role:umum');
		Route::post('kontrak/laporan', [KontrakController::class, 'report'])->name('kontrak.laporan')->middleware('role:ketua_tim,umum');
		Route::post('kontrak/export', [KontrakController::class, 'export'])->name('kontrak.export')->middleware('role:ketua_tim,umum');

		Route::resource('user', UserController::class)->except('show')->middleware('role:ketua_tim,umum');

		Route::get('profil', [ProfilController::class, 'index'])->name('profil.index');
		Route::patch('profil-info', [ProfilController::class, 'info'])->name('profil.info');
		Route::patch('profil-pwd', [ProfilController::class, 'password'])->name('profil.pwd');

		Route::resource('tambahan', SettingsController::class)->except(['create', 'store']);
	});
});
