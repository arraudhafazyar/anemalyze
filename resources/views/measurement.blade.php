<x-layout :title="$title">
    <div class="m-4">
        <h2 class="rounded-lg bg-[#CD5656] text-white font-semibold p-2 px-6 my-4">Data Diri Pasien</h2>
        
        {{-- Data Pasien (selalu tampil, read-only) --}}
        <div class="mx-4 grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label for="nama">Nama Pasien</label>
                <input type="text" id="nama" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->name }}" disabled>
            </div>
            <div class="flex flex-col">
                <label for="phone-number">Nomor Telepon</label>
                <input type="text" id="phone-number" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->phone_number }}" disabled>
            </div>
        </div>
        
        <div class="mx-4 grid grid-cols-2 mt-4 gap-4">
            <div class="flex flex-col">
                <label for="placeborn">Tempat lahir</label>
                <input type="text" id="placeborn" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->tempat_lahir }}" disabled>
            </div>
            <div class="flex flex-col">
                <label for="birthdate">Tanggal Lahir</label>
                <input type="date" id="birthdate" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->tanggal_lahir }}" disabled>
            </div>
        </div>
        
        <h2 class="rounded-lg bg-[#CD5656] text-white font-semibold p-2 px-6 my-4">Riwayat Kesehatan</h2>
        
        {{-- 🔥 FORM ANAMNESIS (Tampil jika $showForm = true) --}}
        @if($showForm)
        <form id="pemeriksaanForm" action="{{ route('pemeriksaan.store', $pasien->slug) }}" method="POST">
            @csrf
            
            <div class="mx-8 mt-4 grid grid-cols-2 gap-4">
                <div class="flex flex-col col-span-2">
                    <label for="detail">Detail anamnesis <span class="text-red-500">*</span></label>
                    <textarea 
                        id="detail" 
                        name="keluhan" 
                        class="bg-[#ebe6e6] rounded-lg px-3 py-2" 
                        rows="3" 
                        placeholder="Tuliskan keluhan pasien..."
                        required>{{ old('keluhan', $currentAnamnesis->keluhan ?? '') }}</textarea>
                    @error('keluhan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="mx-8">
                <div class="flex space-x-20 flex-wrap mb-4">
                    <x-radiobutton 
                        label="Riwayat Kehamilan"
                        name="kehamilan"
                        :options="[
                            'Nulligravida' => 'Nulligravida',
                            'Primigravida' => 'Primigravida',
                            'Multigravida' => 'Multigravida'
                        ]"
                        :selected="old('kehamilan', $currentAnamnesis?->kehamilan ?? '')"
                    />
                    
                    <x-radiobutton
                        label="Riwayat Takikardia"
                        name="takikardia"
                        :options="['ya' => 'Ya', 'tidak' => 'Tidak']"
                        :selected="old('takikardia', $currentAnamnesis?->takikardia == 1 ? 'ya' : ($currentAnamnesis ? 'tidak' : ''))"
                    />
                    
                    <x-radiobutton
                        label="Riwayat Hipertensi"
                        name="hipertensi"
                        :options="['ya' => 'Ya', 'tidak' => 'Tidak']"
                        :selected="old('hipertensi', $currentAnamnesis?->hipertensi == 1 ? 'ya' : ($currentAnamnesis ? 'tidak' : ''))"
                    />
                </div>
                
                <div class="flex space-x-6">
                    <x-radiobutton
                        label="Kebiasaan Merokok"
                        name="kebiasaan_merokok"
                        :options="[
                            'Pasif' => 'Perokok pasif',
                            'Aktif' => 'Perokok aktif',
                            'Tidak merokok' => 'Tidak merokok'
                        ]"
                        :selected="old('kebiasaan_merokok', $currentAnamnesis?->kebiasaan_merokok ?? '')"
                    />
                    
                    <x-radiobutton
                        label="Riwayat Transfusi Darah"
                        name="transfusi"
                        :options="['ya' => 'Ya', 'tidak' => 'Tidak']"
                        :selected="old('transfusi', $currentAnamnesis?->transfusi_darah == 1 ? 'ya' : ($currentAnamnesis ? 'tidak' : ''))"
                    />
                </div>
            </div>
            
            <div class="flex justify-end m-4">
                <button 
                    id="simpanData"
                    type="submit"
                    class="rounded-full px-5 py-2.5 bg-[#CD5656] text-white hover:bg-[#b84a4a] flex items-center space-x-2 transition">
                    <i class="fa-solid fa-save"></i>
                    <span class="text-sm font-semibold">Simpan Data</span>
                </button>
            </div>
        </form>
        @endif
        
        {{-- 🔥 TOMBOL MULAI PENGUKURAN --}}
        @if($hasPendingMeasurement && $currentAnamnesis)
        <div class="mx-8 mb-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <p class="text-green-700 flex items-center">
                    <i class="fa-solid fa-check-circle mr-2"></i>
                    Data anamnesis sudah tersimpan. Silakan lakukan pengukuran.
                </p>
            </div>
            
            {{-- Preview data anamnesis --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-gray-200">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fa-solid fa-clipboard-list mr-2 text-[#CD5656]"></i>
                    Data Anamnesis Tersimpan
                </h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="flex">
                        <span class="font-medium text-gray-600 w-24">Keluhan:</span>
                        <span class="text-gray-800">{{ $currentAnamnesis->keluhan ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-600 w-24">Kehamilan:</span>
                        <span class="text-gray-800">{{ $currentAnamnesis->kehamilan }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-600 w-24">Takikardia:</span>
                        <span class="text-gray-800">{{ $currentAnamnesis->takikardia ? 'Ya' : 'Tidak' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-600 w-24">Hipertensi:</span>
                        <span class="text-gray-800">{{ $currentAnamnesis->hipertensi ? 'Ya' : 'Tidak' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-600 w-24">Merokok:</span>
                        <span class="text-gray-800">{{ $currentAnamnesis->kebiasaan_merokok }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-600 w-24">Transfusi:</span>
                        <span class="text-gray-800">{{ $currentAnamnesis->transfusi_darah ? 'Ya' : 'Tidak' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button 
                    id="btn-mulai-pengukuran"
                    data-url="{{ route('anamnesis.measurement.start', ['pasien' => $pasien->slug, 'anamnesis' => $currentAnamnesis->id]) }}"
                    type="button"
                    class="rounded-full px-6 py-3 bg-[#CD5656] text-white hover:bg-[#b84a4a] flex items-center space-x-2 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fa-solid fa-play"></i>
                    <span class="text-sm font-semibold">Mulai Pengukuran</span>
                </button>
            </div>
        </div>
        @endif
        
        {{-- Modal Pengukuran --}}
        @include('components.measurement-modal')
    </div>
</x-layout>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/measurement.js') }}"></script>

{{-- Validation Errors --}}
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        html: '<ul style="text-align: left;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        confirmButtonColor: '#CD5656'
    });
</script>
@endif

{{-- Success Message --}}
@if (session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
    });
</script>
@endif

{{-- Error Message --}}
@if (session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
</script>
@endif

{{-- Form Submit Handler --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pemeriksaanForm');
    const btnSimpan = document.getElementById('simpanData');
    
    if (form && btnSimpan) {
        form.addEventListener('submit', function(e) {
            // Validasi form sebelum submit
            const keluhan = document.getElementById('detail').value.trim();
            
            if (!keluhan) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Keluhan pasien harus diisi!',
                    confirmButtonColor: '#CD5656'
                });
                return false;
            }
            
            // Ganti tampilan tombol jadi loading
            btnSimpan.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                <span class="text-sm font-semibold">Menyimpan...</span>
            `;
            btnSimpan.disabled = true;
        });
    }
});
</script>
