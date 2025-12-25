<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesis;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PemeriksaanController extends Controller
{
    /**
     * ========================================
     * SHOW FORM TAMBAH KUNJUNGAN
     * ========================================
     * Route: GET /home/{pasien:slug}/tambah
     */
    public function create(Pasien $pasien)
{
    // Ambil anamnesis_id dari session (setelah store)
    $anamnesisId = session('anamnesis_id');
    
    // Default values
    $currentAnamnesis = null;
    $hasPendingMeasurement = false;
    $showForm = true; // Default tampilkan form
    
    if ($anamnesisId) {
        $currentAnamnesis = Anamnesis::find($anamnesisId);
        
        if ($currentAnamnesis) {
            // Cek apakah ada pemeriksaan yang belum diisi
            $hasPendingMeasurement = Pemeriksaan::where('anamnesis_id', $currentAnamnesis->id)
                ->whereNull('status_anemia')
                ->exists();
            
            // 🔥 FIX: Jangan hide form kalau baru redirect dari store
            // Cek juga flag dari session
            if (session('show_measurement_button')) {
                $showForm = false;
            } else {
                $showForm = !$hasPendingMeasurement;
            }
        }
    }
    
    return view('measurement', [
        'title' => 'Tambah Pengukuran ' . explode(' ', $pasien->name)[0],
        'pasien' => $pasien,
        'currentAnamnesis' => $currentAnamnesis,
        'hasPendingMeasurement' => $hasPendingMeasurement,
        'showForm' => $showForm
    ]);
}


    /**
     * ========================================
     * STORE ANAMNESIS BARU + PEMERIKSAAN KOSONG
     * ========================================
     * Route: POST /home/{pasien:slug}/tambah
     */
    public function store(Request $request, Pasien $pasien)
    {
        // Validasi input
        $validated = $request->validate([
            'keluhan' => 'nullable|string',
            'kehamilan'=> 'required|in:Nulligravida,Primigravida,Multigravida',
            'takikardia' => 'required|in:ya,tidak',
            'hipertensi' => 'required|in:ya,tidak',
            'transfusi'  => 'required|in:ya,tidak',
            'kebiasaan_merokok' => 'required|in:Pasif,Aktif,Tidak merokok',
        ]);

        // Buat anamnesis BARU untuk pasien ini
        $anamnesis = $pasien->anamneses()->create([
            'keluhan' => $validated['keluhan'] ?? null,
            'kehamilan' => $validated['kehamilan'],
            'takikardia' => $validated['takikardia'] === 'ya' ? 1 : 0,
            'hipertensi' => $validated['hipertensi'] === 'ya' ? 1 : 0,
            'transfusi_darah' => $validated['transfusi'] === 'ya' ? 1 : 0,
            'kebiasaan_merokok' => $validated['kebiasaan_merokok'],
        ]);

        // Buat pemeriksaan KOSONG
        $pemeriksaan = new Pemeriksaan();
        $pemeriksaan->spo2 = null;
        $pemeriksaan->heart_rate = null;
        $pemeriksaan->status_anemia = null;
        $pemeriksaan->confidence = null;
        $pemeriksaan->image_path = null;
        $pemeriksaan->pasien_id = $pasien->id;
        $pemeriksaan->anamnesis_id = $anamnesis->id;
        $pemeriksaan->save();

        // Redirect ke measurement.blade.php dengan anamnesis_id
        return redirect()
            ->route('pemeriksaan.create', $pasien->slug)
            ->with('success', 'Data anamnesis berhasil disimpan!')
            ->with('anamnesis_id', $anamnesis->id)
            ->with('show_measurement_button', true);
    }

    /**
     * ========================================
     * MULAI PENGUKURAN (AI + SENSOR)
     * ========================================
     * Route: POST /home/{pasien:slug}/{anamnesis}/start
     */
    public function startMeasurement(Pasien $pasien, Anamnesis $anamnesis)
    {
        try {
            Log::info(" Starting measurement for pasien: {$pasien->name}, anamnesis_id: {$anamnesis->id}");

            // Validasi anamnesis milik pasien ini
            if ($anamnesis->pasien_id !== $pasien->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anamnesis tidak sesuai dengan pasien'
                ], 403);
            }

            // Ambil pemeriksaan yang masih NULL untuk anamnesis ini
            $pemeriksaan = Pemeriksaan::where('pasien_id', $pasien->id)
                ->where('anamnesis_id', $anamnesis->id)
                ->whereNull('status_anemia')
                ->first();

            if (!$pemeriksaan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pemeriksaan untuk kunjungan ini sudah dilakukan atau data tidak ditemukan.'
                ], 404);
            }

            Log::info("Found pemeriksaan_id: {$pemeriksaan->id}");

            // HIT FLASK API
            $apiUrl = 'http://localhost:5000/api/measure';
            
            $response = Http::timeout(60)->post($apiUrl);

            if (!$response->successful()) {
                Log::error("API Error: " . $response->body());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghubungi API Python: ' . $response->status()
                ], 500);
            }

            $data = $response->json();

            if ($data['status'] !== 'success') {
                return response()->json([
                    'success' => false,
                    'message' => 'API mengembalikan error: ' . ($data['message'] ?? 'Unknown error')
                ], 500);
            }

            $measurementData = $data['data'];

            Log::info("✓ API Response:", $measurementData);

            // Return data untuk ditampilkan di modal
            return response()->json([
                'success' => true,
                'message' => 'Pengukuran berhasil!',
                'data' => [
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'anamnesis_id' => $anamnesis->id,
                    'status_anemia' => $measurementData['status_anemia'],
                    'confidence' => $measurementData['confidence'],
                    'heart_rate' => $measurementData['heart_rate'],
                    'spo2' => $measurementData['spo2'],
                    'image_path' => $measurementData['image_path'] ?? null,
                    'timestamp' => $measurementData['timestamp']
                ]
            ], 200);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("Connection Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server Python. Pastikan API Flask berjalan di port 5000.'
            ], 503);

        } catch (\Exception $e) {
            Log::error('Start Measurement Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ========================================
     * SIMPAN HASIL PENGUKURAN KE DATABASE
     * ========================================
     * Route: POST /home/{pasien:slug}/{anamnesis}/save
     */
    public function saveMeasurement(Request $request, Pasien $pasien, Anamnesis $anamnesis)
{
    try {
        $validated = $request->validate([
            // HAPUS pemeriksaan_id dari validation
            'status_anemia' => 'required|string',
            'confidence' => 'required|numeric|min:0|max:100',
            'heart_rate' => 'required|integer|min:0|max:300',
            'spo2' => 'required|integer|min:0|max:100',
            'image_path' => 'nullable|string|max:255'
        ]);

        // CARI pemeriksaan berdasarkan anamnesis_id
        $pemeriksaan = Pemeriksaan::where('pasien_id', $pasien->id)
            ->where('anamnesis_id', $anamnesis->id)
            ->whereNull('status_anemia')
            ->first();

        if (!$pemeriksaan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemeriksaan tidak ditemukan atau sudah terisi'
            ], 404);
        }

        // UPDATE pemeriksaan
        $pemeriksaan->update([
            'status_anemia' => ucfirst($validated['status_anemia']),
            'confidence' => $validated['confidence'],
            'heart_rate' => $validated['heart_rate'],
            'spo2' => $validated['spo2'],
            'image_path' => $validated['image_path'] ?? null,
        ]);

        Log::info("✓ Measurement saved for pasien: {$pasien->name}, pemeriksaan_id: {$pemeriksaan->id}");

        return response()->json([
            'success' => true,
            'message' => 'Hasil pengukuran berhasil disimpan!',
            'data' => $pemeriksaan,
            // FIX: Tambahkan anamnesis parameter!
            'redirect_url' => route('home.show', [
                'pasien' => $pasien->slug,
                'anamnesis' => $anamnesis->id
            ])
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid: ' . $e->getMessage()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Save Measurement Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan hasil: ' . $e->getMessage()
        ], 500);
    }
}
}
