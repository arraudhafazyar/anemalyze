{{-- 
    Modal Pengukuran Anemia 
--}}

{{-- ============ MODAL LOADING ============ --}}
<div id="loading-modal" class="fixed inset-0 bg-black/60 flex justify-center items-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-11/12 text-center shadow-2xl">
        {{-- Spinner --}}
        <div class="flex justify-center py-5">
            <div class="w-14 h-14 border-4 border-gray-200 border-t-[#CD5656] rounded-full animate-spin"></div>
        </div>
        <h3 class="mt-4 text-xl font-semibold text-gray-800">Menganalisis...</h3>
        <p class="mt-2 text-gray-600">Mohon tunggu, proses pengukuran sedang berlangsung</p>
        <div class="mt-4 text-sm text-gray-500 space-y-1">
            <p> Mengambil gambar konjungtiva...</p>
            <p> Menganalisis dengan AI...</p>
            <p> Membaca sensor...</p>
        </div>
    </div>
</div>

{{-- ============ MODAL HASIL PENGUKURAN ============ --}}
<div id="result-modal" class="fixed inset-0 bg-black/60 flex justify-center items-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-xl w-11/12 max-h-[90vh] overflow-y-auto shadow-2xl">
        
        {{-- Header --}}
        <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-5">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fa-solid fa-stethoscope mr-2 text-[#CD5656]"></i>
                Hasil Pengukuran
            </h3>
            <button type="button" id="btn-close-modal" class="text-gray-500 hover:text-gray-800 hover:bg-gray-100 p-2 rounded-lg transition">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>
        
        {{-- Body --}}
        <div class="space-y-6">
            
            {{-- Gambar Konjungtiva --}}
            <div>
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Gambar Konjungtiva</h4>
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <img id="result-image" src="" alt="Gambar Konjungtiva" class="max-w-full max-h-48 rounded-lg mx-auto object-contain">
                </div>
            </div>
            
            {{-- Hasil AI --}}
            <div>
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Hasil Klasifikasi AI</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <span class="block text-xs text-gray-500 mb-2">Status Anemia</span>
                        <span id="result-status" class="inline-block px-4 py-2 rounded-full text-base font-semibold">-</span>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <span class="block text-xs text-gray-500 mb-2">Confidence</span>
                        <span id="result-confidence" class="text-2xl font-bold text-gray-800">-%</span>
                    </div>
                </div>
            </div>
            
            {{-- Hasil Sensor --}}
            <div>
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Hasil Sensor MAX30100</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center flex flex-col items-center gap-2">
                        <i class="fa-solid fa-lungs text-blue-500 text-2xl"></i>
                        <span class="text-xs text-gray-500">Saturasi Oksigen (SpO2)</span>
                        <span id="result-spo2" class="text-2xl font-bold text-blue-600">-%</span>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center flex flex-col items-center gap-2">
                        <i class="fa-solid fa-heartbeat text-red-500 text-2xl"></i>
                        <span class="text-xs text-gray-500">Detak Jantung</span>
                        <span id="result-hr" class="text-2xl font-bold text-red-600">- bpm</span>
                    </div>
                </div>
            </div>
            
        </div>
        
        {{-- Footer --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 mt-6">
            <button type="button" id="btn-ulangi" class="rounded-full px-5 py-2.5 bg-gray-200 text-gray-700 hover:bg-gray-300 flex items-center space-x-2 transition">
                <i class="fa-solid fa-redo"></i>
                <span class="text-sm font-semibold">Ulangi</span>
            </button>
            <button type="button" id="btn-simpan-hasil" class="rounded-full px-5 py-2.5 bg-[#CD5656] text-white hover:bg-[#b84a4a] flex items-center space-x-2 transition">
                <i class="fa-solid fa-save"></i>
                <span class="text-sm font-semibold">Simpan Hasil</span>
            </button>
        </div>
        
    </div>
</div>