{{-- 
    Modal Pengukuran Anemia dengan Live Preview
    Flow: Preview → Capture → Review → Analyze → Result → Save
--}}

{{-- ============ MODAL UTAMA ============ --}}
<div id="measurement-modal" class="fixed inset-0 bg-black/70 flex justify-center items-center z-50 hidden">
    <div class="bg-white rounded-2xl max-w-2xl w-11/12 max-h-[95vh] overflow-hidden shadow-2xl">
        
        {{-- Header --}}
        <div class="bg-[#CD5656] text-white px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold flex items-center">
                <i class="fa-solid fa-stethoscope mr-2"></i>
                <span id="modal-title">Pengukuran Anemia</span>
            </h3>
            <button type="button" id="btn-close-modal" class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-lg transition">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>
        
        {{-- Body --}}
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            
            {{-- ========== STEP 1: LIVE PREVIEW ========== --}}
            <div id="step-preview" class="step-content">
                <div class="text-center mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fa-solid fa-video mr-2"></i> Step 1: Live Preview
                    </span>
                </div>
        
                
                {{-- Video Stream --}}
                <div class="bg-black rounded-xl overflow-hidden mb-4 relative">
                    <img id="video-stream" 
                         src="" 
                         alt="Live Preview" 
                         class="w-full h-64 md:h-80 object-contain">
                    
                    {{-- Loading overlay --}}
                    <div id="video-loading" class="absolute inset-0 bg-black/80 flex flex-col items-center justify-center">
                        <div class="w-10 h-10 border-4 border-white/30 border-t-white rounded-full animate-spin mb-3"></div>
                        <span class="text-white text-sm">Memuat kamera...</span>
                    </div>
                </div>
                
                <div class="flex justify-center gap-3">
                    <button type="button" id="btn-capture" class="px-6 py-3 bg-[#CD5656] text-white rounded-full font-semibold hover:bg-[#b84a4a] transition flex items-center">
                        <i class="fa-solid fa-camera mr-2"></i>
                        Capture
                    </button>
                    <button type="button" id="btn-cancel-preview" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition">
                        Batal
                    </button>
                </div>
            </div>
            
            {{-- ========== STEP 2: REVIEW FOTO ========== --}}
            <div id="step-review" class="step-content hidden">
                <div class="text-center mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fa-solid fa-image mr-2"></i> Step 2: Review Foto
                    </span>
                </div>
                
                
                {{-- Captured Image --}}
                <div class="bg-gray-100 rounded-xl overflow-hidden mb-4">
                    <img id="captured-image" 
                         src="" 
                         alt="Hasil Capture" 
                         class="w-full h-64 md:h-80 object-contain">
                </div>
                
                <div class="flex justify-center gap-3">
                    <button type="button" id="btn-retake" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition flex items-center">
                        <i class="fa-solid fa-redo mr-2"></i>
                        Ulangi
                    </button>
                    <button type="button" id="btn-analyze" class="px-6 py-3 bg-[#CD5656] text-white rounded-full font-semibold hover:bg-[#b84a4a] transition flex items-center">
                        <i class="fa-solid fa-microscope mr-2"></i>
                        Lanjut Analisis
                    </button>
                </div>
            </div>
            
            {{-- ========== STEP 3: ANALYZING ========== --}}
            <div id="step-analyzing" class="step-content hidden">
                <div class="text-center py-10">
                    <div class="w-16 h-16 border-4 border-gray-200 border-t-[#CD5656] rounded-full animate-spin mx-auto mb-6"></div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Menganalisis...</h4>
                    
                    <div class="space-y-2 text-sm text-gray-500">
                        <p id="analyze-step-1" class="flex items-center justify-center">
                            <i class="fa-solid fa-spinner fa-spin mr-2 text-[#CD5656]"></i>
                            Menganalisis gambar...
                        </p>
                        <p id="analyze-step-2" class="flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-circle mr-2 text-xs"></i>
                            Membaca sensor...
                        </p>
                    </div>
                    
                    <p class="mt-6 text-sm text-gray-500">
                        <i class="fa-solid fa-hand-point-up mr-1"></i>
                        Letakkan jari pada sensor!
                    </p>
                </div>
            </div>
            
            {{-- ========== STEP 4: RESULT ========== --}}
            <div id="step-result" class="step-content hidden">
                <div class="text-center mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fa-solid fa-check-circle mr-2"></i> Hasil Pengukuran
                    </span>
                </div>
                
                {{-- Gambar --}}
                <div class="bg-gray-50 rounded-xl p-3 mb-4">
                    <img id="result-image" src="" alt="Gambar Konjungtiva" class="max-w-full max-h-40 rounded-lg mx-auto object-contain">
                </div>
                
                {{-- Status Anemia --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <span class="block text-xs text-gray-500 mb-2">Status Anemia</span>
                        <span id="result-status" class="inline-block px-4 py-2 rounded-full text-base font-semibold">-</span>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <span class="block text-xs text-gray-500 mb-2">Confidence</span>
                        <span id="result-confidence" class="text-2xl font-bold text-gray-800">-%</span>
                    </div>
                </div>
                
                {{-- Sensor --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <i class="fa-solid fa-lungs text-blue-500 text-2xl mb-2"></i>
                        <span class="block text-xs text-gray-500">SpO2</span>
                        <span id="result-spo2" class="text-2xl font-bold text-blue-600">-%</span>
                    </div>
                    <div class="bg-red-50 rounded-xl p-4 text-center">
                        <i class="fa-solid fa-heartbeat text-red-500 text-2xl mb-2"></i>
                        <span class="block text-xs text-gray-500">Heart Rate</span>
                        <span id="result-hr" class="text-2xl font-bold text-red-600">- bpm</span>
                    </div>
                </div>
                
                {{-- Buttons --}}
                <div class="flex justify-center gap-3 pt-2">
                    <button type="button" id="btn-new-measurement" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition flex items-center">
                        <i class="fa-solid fa-redo mr-2"></i>
                        Ukur Ulang
                    </button>
                    <button type="button" id="btn-save-result" class="px-5 py-2.5 bg-[#CD5656] text-white rounded-full font-semibold hover:bg-[#b84a4a] transition flex items-center">
                        <i class="fa-solid fa-save mr-2"></i>
                        Simpan Hasil
                    </button>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
