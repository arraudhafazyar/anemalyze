<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Http\Request;

class AnamnesisController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'kehamilan'=> 'required|in:Nulligravida, primigravida, Multigravida',
            'takikardia' => 'required|in:ya,tidak',
            'hipertensi' => 'required|in:ya,tidak',
            'transfusi_darah'  => 'required|in:ya,tidak',
            'kebiasaan_merokok' => 'required|in:Pasif, Aktif, Tidak Merokok',
            'keluhan' => 'required|string',
        ]);

        Anamnesis::create([
        'kehamilan' => $request->riwayat,
        'takikardia' =>$request->takikardia,
        'hipertensi' => $request->hipertensi,
        'transfusi_darah'=> $request->transfusi,
        'kebiasaan_merokok'=>$request->merokok,
        'keluhan'=>$request->detail,
    ]);
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
            'keluhan' => 'required|string',
            'riwayat' => 'required|string',
            'takikardia' => 'required|string',
            'hipertensi' => 'required|string',
            'merokok' => 'required|string',
            'transfusi' => 'required|string',
        ]);

        $anamnesis->update($validated);

        return redirect()->route('anamnesis.show', [$pasien->id, $anamnesis->id])
                        ->with('success', 'Data anamnesis berhasil diperbarui!');
    }
    }
