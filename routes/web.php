<?php

use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnamnesisController;
use App\Http\Controllers\pasienController;


Route::get('/', [HomeController::class, 'index'])->name('login');;

Route::middleware('guest')->group(function () {
    Route::post('/', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home',  [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/home/{pasien:slug}/{anamnesis}', [pasienController::class, 'show'])->name('home.show');



Route::post('/pasien-baru', [AnamnesisController::class, 'store'])->name('anamnesis.store');
Route::get('/pasien-baru', [pasienController::class, 'create']);
Route::get('/home/{pasien:slug}/{anamnesis}/edit', [AnamnesisController::class, 'edit'])->name('anamnesis.edit');
Route::put('/home/{pasien:slug}/{anamnesis}', [AnamnesisController::class, 'update'])->name('anamnesis.update');
