<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pasienbaruController extends Controller
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
}
