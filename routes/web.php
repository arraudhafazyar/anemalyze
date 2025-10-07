<?php

use App\Http\Controllers\AuthController;
use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



// Route::post('/', function () {
//     return view('login', ['title' => 'Login', LoginController::class, 'authentication']);
// });
Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'home'])->name('home');
});

// Route::get('/home/{pasien:slug}', function(Pemeriksaan $pemeriksaan){
//     return view('detail', ['title' => 'Detail Pasien', 'pemeriksaan'=>$pemeriksaan]);
// });
Route::get('/home/{pasien:slug}/{anamnesis_id}', function (Pasien $pasien, $anamnesis_id ){
    $anamnesis = Anamnesis::find($anamnesis_id);
    return view ('detail', ['title' => 'Detail Pasien', 'pasien'=> $pasien, 'anamnesis'=> $anamnesis]);
});
Route::get('/detail', function () {
    return view('detail', ['title' => 'Detail Pasien']);
});
Route::get('/pasien-baru', function () {
    return view('pasien-baru', ['title' => 'Detail Pasien']);
});
