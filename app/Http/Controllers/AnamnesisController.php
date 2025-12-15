<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class AnamnesisController extends Controller
{
    /**
     * ========================================
     * STORE PASIEN BARU + ANAMNESIS PERTAMA
     * ========================================
     * Route: POST /pasien-baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'placeborn' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'kehamilan'=> 'required|in:Nulligravida,Primigravida,Multigravida',
            'takikardia' => 'required|in:ya,tidak',
            'hipertensi' => 'required|in:ya,tidak',
            'transfusi'  => 'required|in:ya,tidak',
            'kebiasaan_merokok' => 'required|in:Pasif,Aktif,Tidak merokok',
            'keluhan' => 'required|string'
        ]);

        // Bikin pasien BARU
        $pasien = Pasien::create([
            'name' => $validated['nama'],
            'phone_number' => $validated['phone_number'],
            'tempat_lahir' => $validated['placeborn'],
            'tanggal_lahir' => $validated['birthdate'],
        ]);

        // Bikin anamnesis PERTAMA
        $anamnesis = $pasien->anamneses()->create([
            'keluhan' => $validated['keluhan'],
            'kehamilan' => $validated['kehamilan'],
            'takikardia' => $validated['takikardia'] === 'ya' ? 1 : 0,
            'hipertensi' => $validated['hipertensi'] === 'ya' ? 1 : 0,
            'transfusi_darah'=> $validated['transfusi'] === 'ya' ? 1 : 0,
            'kebiasaan_merokok'=>$validated['kebiasaan_merokok'],
        ]);

        // Bikin pemeriksaan KOSONG
        $pemeriksaan = new Pemeriksaan();
        $pemeriksaan->spo2 = null;
        $pemeriksaan->heart_rate = null;
        $pemeriksaan->status_anemia = null;
        $pemeriksaan->confidence = null;
        $pemeriksaan->image_path = null;
        $pemeriksaan->pasien_id = $pasien->id;
        $pemeriksaan->anamnesis_id = $anamnesis->id;
        $pemeriksaan->save();

        // Redirect ke measurement.blade.php
        return redirect()
            ->route('pemeriksaan.create', ['pasien' => $pasien->slug])
            ->with('success', 'Data pasien berhasil disimpan!')
            ->with('anamnesis_id', $anamnesis->id)
            ->with('is_new_patient', true)
            ->with('show_measurement_button', true);
    }

    /**
     * ========================================
     * EDIT ANAMNESIS
     * ========================================
     * Route: GET /home/{pasien:slug}/{anamnesis}/edit
     */
    public function edit(Pasien $pasien, Anamnesis $anamnesis)
    {
        return view('anamnesis.edit', compact('pasien', 'anamnesis'));
    }

    /**
     * ========================================
     * UPDATE ANAMNESIS
     * ========================================
     * Route: PUT /home/{pasien:slug}/{anamnesis}
     */
    public function update(Request $request, Pasien $pasien, Anamnesis $anamnesis)
    {
        $validated = $request->validate([
            'keluhan' => 'nullable|string',
            'kehamilan' => 'nullable|string',
            'takikardia' => 'nullable|string',
            'hipertensi' => 'nullable|string',
            'merokok' => 'nullable|string',
            'transfusi' => 'nullable|string',
        ]);

        $anamnesis->update([
            'keluhan' => $validated['keluhan'] ?? $anamnesis->keluhan,
            'kehamilan' => $validated['kehamilan'] ?? $anamnesis->kehamilan,
            'takikardia' => $validated['takikardia'] === 'ya' ? 1 : 0,
            'hipertensi' => $validated['hipertensi'] === 'ya' ? 1 : 0,
            'kebiasaan_merokok' => $validated['merokok'] ?? $anamnesis->kebiasaan_merokok,
            'transfusi_darah' => $validated['transfusi'] === 'ya' ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Data anamnesis berhasil diperbarui.');
    }
}