<?php

    namespace App\Http\Controllers;

    use App\Models\Pasien;
    use App\Models\Anamnesis;
    use App\Models\Pemeriksaan;
    use Illuminate\Http\Request;

    class PemeriksaanController extends Controller
    {
        public function create(Pasien $pasien){
            // $anamneses = $pasien->anamneses()->orderByDesc('created_at')->get();

            return view('measurement', ['title'=>'Tambah Pengukuran ' . explode (' ', $pasien->name)[0], 'pasien' => $pasien, 'anamnesis' => null]);
        }
        public function store(Request $request, Pasien $pasien)
    {
        // 1️⃣ Validasi input manual dari form
        $validated = $request->validate([
            'keluhan' => 'nullable|string',
            'kehamilan'=> 'required|in:Nulligravida,Primigravida,Multigravida',
            'takikardia' => 'required|in:ya,tidak',
            'hipertensi' => 'required|in:ya,tidak',
            'transfusi'  => 'required|in:ya,tidak',
            'kebiasaan_merokok' => 'required|in:Pasif,Aktif,Tidak merokok',
        ]);

        // 2 Buat anamnesis baru untuk pasien ini
        $anamnesis = $pasien->anamneses()->create([
            'keluhan' => $validated['keluhan'] ?? null,
            'kehamilan' => $validated['kehamilan'],
            'takikardia' => $validated['takikardia'] === 'ya' ? 1 : 0,
            'hipertensi' => $validated['hipertensi'] === 'ya' ? 1 : 0,
            'transfusi_darah' => $validated['transfusi'] === 'ya' ? 1 : 0,
            'kebiasaan_merokok' => $validated['kebiasaan_merokok'],
        ]);

        //  Buat pemeriksaan baru (sementara masih dummy) nanti kaalu sudah ada data dari sensor ganti ini
        // $pemeriksaan = $anamnesis->pemeriksaan()->create([
        //     'spo2' => 98, // nanti diganti data dari sensor
        //     'heart_rate' => 75, // nanti diganti data dari sensor
        //     'status_anemia' => 'Normal', // nanti diganti hasil model ML kamu
        //     'pasien_id' => $pasien->id,
        // ]);

        // dummy pemeriksaan
        $pemeriksaan = new \App\Models\Pemeriksaan();
        $pemeriksaan->spo2 = 98; // nanti diganti data dari sensor
        $pemeriksaan->heart_rate = 75; // nanti diganti data dari sensor
        $pemeriksaan->status_anemia = 'Normal'; // nanti diganti hasil model ML kamu
        $pemeriksaan->pasien_id = $pasien->id; // otomatis dari route
        $pemeriksaan->anamnesis_id = $anamnesis->id; // hasil yang baru dibuat
        $pemeriksaan->save();


        // Redirect balik ke detail pasien
        return redirect()
            ->route('home.show', [$pasien->slug, $anamnesis->id])
            ->with('success', 'Data berhasil disimpan!');
    }

    }

