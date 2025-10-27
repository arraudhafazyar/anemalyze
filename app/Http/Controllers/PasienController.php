<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class pasienController extends Controller
{
    public function create(Pasien $pasien){
        return view('pasien-baru', ['title' => 'Tambah Pasien', 'pasien' => $pasien, 'anamnesis' => null]);
    }

    public function show(Pasien $pasien, $anamnesis_id)
    {
        #tampilkan anamnesis milik pasien saja
        $anamnesis = $pasien->anamneses()->findOrFail($anamnesis_id); // langsung 404 jika bukan milik pasien
        $anamnesis->load('pemeriksaan');

        # tampilkan semua pemeriksaan milik pasien
        $pemeriksaans = $pasien->anamneses()->with('pemeriksaan')->get();

        return view('detail',
        ['pasien'=> $pasien,
        'anamnesis'=> $anamnesis,
        'pemeriksaans'=>$pemeriksaans,
        'title' => 'Detail Pasien'], compact('pasien', 'anamnesis'));
    }




}
