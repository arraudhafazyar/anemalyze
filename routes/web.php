<?php

use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\pasienController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\AnamnesisController;


Route::get('/', [HomeController::class, 'index'])->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home',  [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// tampilkan form tambah pemeriksaan (prefill biodata pasien)
Route::get('/home/{pasien:slug}/tambah', [PemeriksaanController::class, 'create'])->name('pemeriksaan.create');
// simpan pemeriksaan baru (dari form)
Route::post('/home/{pasien:slug}/tambah', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');

// route untuk halaman detail
Route::get('/home/{pasien:slug}/{anamnesis}', [PasienController::class, 'show'])->name('home.show');
Route::put('/home/{pasien:slug}/{anamnesis}', [AnamnesisController::class, 'update'])->name('anamnesis.update');
Route::get('/home/{pasien:slug}/{anamnesis}/edit', [AnamnesisController::class, 'edit'])->name('anamnesis.edit');

// 🔥 GANTI INI - Pindah ke PemeriksaanController
Route::post('/home/{pasien:slug}/{anamnesis}/start', [PemeriksaanController::class, 'startMeasurement'])->name('anamnesis.measurement.start');
Route::post('/home/{pasien:slug}/{anamnesis}/save', [PemeriksaanController::class, 'saveMeasurement'])->name('anamnesis.measurement.save');

// menambahkan pasien baru dari home
Route::post('/pasien-baru', [AnamnesisController::class, 'store'])->name('anamnesis.store');
Route::get('/pasien-baru', [PasienController::class, 'create'])->name('pasien.create');
