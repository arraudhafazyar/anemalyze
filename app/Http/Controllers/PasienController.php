<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class pasienController extends Controller
{
    public function create() {
        return view('pasien-baru', ['title' => 'Tambah Pasien']);
}
    public function store(Request $request){
        $request->validate([
        'name' => 'required|string|max:255',
        'phone_number'=> 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        ]);
    }

    public function show(Pasien $pasien, Anamnesis $anamnesis)
    {
        // // $anamnesis = Anamnesis::find($anamnesis->id);
        // $pemeriksaan = $anamnesis->pemeriksaan;
        // $anamnesis = $pasien->anamneses()->where('id', $anamnesis->id)->first();

        $anamnesis = $pasien->anamneses()
        ->where('id', $anamnesis->id)
        ->first();

        $pemeriksaan = $anamnesis ? $anamnesis->pemeriksaan : null;

        return view('detail',
        ['pasien'=> $pasien,
        'anamnesis'=> $anamnesis,
        'pemeriksaan'=>$pemeriksaan,
        'title' => 'Detail Pasien']);
    }




}
