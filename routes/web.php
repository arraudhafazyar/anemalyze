<?php

use App\Models\Pasien;
use App\Models\Anamnesis;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});
Route::post('/', function () {
    return view('login', ['title' => 'Login', LoginController::class, 'authentication']);
});

Route::get('/home', function () {
    return view('home', ['title' => 'Home', 'pemeriksaans'=>Pemeriksaan::filter(request(['search', 'pasien', 'anamnesis']))->latest()->paginate(7)->withQueryString()]);
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
