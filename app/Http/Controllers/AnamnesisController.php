<?php

namespace App\Http\Controllers;

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
}
