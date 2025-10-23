<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function create(Pasien $pasien, Anamnesis $anamneses){
         $anamneses = $pasien->anamneses()->orderByDesc('created_at')->get();

        return view('measurement', [compact('pasien', 'anamneses'), 'title'=>'Tambah Pengukuran ' . explode (' ', $pasien->name)[0], 'pasien' => $pasien]);
    }
    public function store(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'anamnesis_id' => 'nullable|exists:anamneses,id',
            'keluhan' => 'nullable|string',
            'spo2' => 'required|integer|min:0|max:100',
            'heart_rate' => 'required|integer|min:20|max:300',
        ]);

        // // jika tidak pilih anamnesis -> buat anamnesis baru
        // if (empty($validated['anamnesis_id'])) {
        //     $anamnesis = Anamnesis::create([
        //         'pasien_id' => $pasien->id,
        //         'keluhan' => $validated['keluhan'] ?? null,
        //         // jika field lain wajib, tambahkan di sini
        //     ]);
        // } else {
        //     $anamnesis = Anamnesis::find($validated['anamnesis_id']);
        // }

        // $pemeriksaan = Pemeriksaan::create([
        //     'anamnesis_id' => $anamnesis->id,
        //     'pasien_id' => $pasien->id,  
        //     'spo2' => $validated['spo2'],
        //     'heart_rate' => $validated['heart_rate'],
        //     // 'status_anemia' => (opsional, hitung di sini jika perlu)
        // ]);

        // return redirect()
        //     ->route('home.show', ['pasien' => $pasien->slug, 'anamnesis' => $anamnesis->id])
        //     ->with('success', 'Pemeriksaan tersimpan.');
    }
}
