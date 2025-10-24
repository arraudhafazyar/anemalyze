<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Http\Request;

class AnamnesisController extends Controller
{
    public function store(Request $request, Pasien $pasien){
            $request->validate([
                'kehamilan'=> 'required|in:Nulligravida, primigravida, Multigravida',
                'takikardia' => 'required|in:ya,tidak',
                'hipertensi' => 'required|in:ya,tidak',
                'transfusi_darah'  => 'required|in:ya,tidak',
                'kebiasaan_merokok' => 'required|in:Pasif, Aktif, Tidak Merokok',
                'keluhan' => 'required|string',
            ]);

            Anamnesis::create([
            'kehamilan' => $request->kehamilan,
            'takikardia' =>$request->takikardia,
            'hipertensi' => $request->hipertensi,
            'transfusi_darah'=> $request->transfusi,
            'kebiasaan_merokok'=>$request->merokok,
            'keluhan'=>$request->detail,
        ]);
        return redirect()
        ->route('home.show', ['pasien' => $pasien->slug, 'anamnesis' => $anamnesis->id])
        ->with('success', 'Data anamnesis berhasil disimpan!');
        }

    public function show(Anamnesis $anamnesis){
        return view('detail', ['title' => 'Detail Pasien', 'anamnesis'=>$anamnesis]);
    }

    public function edit(Pasien $pasien, Anamnesis $anamnesis)
    {
        return view('anamnesis.edit', compact('pasien', 'anamnesis'));
    }

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
