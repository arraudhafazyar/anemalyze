<?php

use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnamnesisController;
use App\Http\Controllers\pasienbaruController;

Route::get('/', [HomeController::class, 'index'])->name('login');;

Route::middleware('guest')->group(function () {
    Route::post('/', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home',  [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/home/{pasien:slug}', function(Pemeriksaan $pemeriksaan){
//     return view('detail', ['title' => 'Detail Pasien', 'pemeriksaan'=>$pemeriksaan]);
// });
Route::get('/home/{pasien:slug}/{anamnesis_id}', function (Pasien $pasien, $anamnesis_id ){
    $anamnesis = Anamnesis::find($anamnesis_id);
    return view ('detail', ['title' => 'Detail Pasien', 'pasien'=> $pasien, 'anamnesis'=> $anamnesis]);
});

// Route::get('/home/{pasien:slug}/{anamnesis_id}', [HomeController::class, 'show']);


Route::post('/pasien-baru', [AnamnesisController::class, 'store'])->name('anamnesis.store');
Route::get('/pasien-baru', [pasienbaruController::class, 'create']);

Route::get('/detail', function () {
    return view('detail', ['title' => 'Detail Pasien']);
});
