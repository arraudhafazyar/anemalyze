<x-layout :title="$title">
<div class="m-4">
    <h2 class="rounded-lg bg-[#73946B] text-white font-semibold p-2 px-6 my-4 ">Detail pasien</h2>
        <div class=" grid grid-cols-3 gap-4">
            <div class="rounded col-span-1 shadow-xl bg-[#B0DB9C] flex flex-col items-center">
                <img src="/img/woman-removebg-preview.png" alt="" class="h-35 mt-8 mb-4">
                <a href="/home/{pasien:slug}"><h2 class="font-bold mb-3">{{ $pasien->name }}</h2></a>
                <h2 class="m-2">{{ $pasien->tempat_lahir}}, {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}</h2>
                <h2 class="m-2" >{{$pasien->phone_number}}</h2>
                <h2 class="mb-8">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</h2>
            </div>
                <div class="flex flex-col col-span-2">
                    <p class="font-medium">Detail anamnesis</p>
                    <textarea name="keluhan" id="keluhan" class="w-full h-32  rounded-lg shadow-xl bg-[#B0DB9C] p-3 active:border-none text-sm"> {{ $anamnesis->keluhan}}</textarea>
                    <div class="flex space-x-16 mb-4">
                        <x-radiobutton label="Riwayat Kehamilan"
                            name="kehamilan"
                            :options="[
                                'Nulligravida' => 'Nulligravida',
                                'Primigravida' => 'Primigravida',
                                'Multigravida' => 'Multigravida'
                            ]"
                            :selected="$anamnesis->kehamilan"
                            :disabled="true"
                        />{{-- riwayat kehamilan --}}
                        <x-radiobutton
                        label="Riwayat Takikardia"
                        name="takikardia"
                        :options="[
                            'ya' => 'Ya',
                            'tidak' => 'Tidak'
                        ]"
                        :selected="$anamnesis->takikardia == 1 ? 'ya' : 'tidak'"
                        :disabled="true"
                        /> {{-- riwayat takikardia --}}
                        <x-radiobutton
                            label="Riwayat Hipertensi"
                            name="hipertensi"
                            :options="[
                                'ya' => 'Ya',
                                'tidak' => 'Tidak'
                            ]"
                            :selected="$anamnesis->hipertensi == 1 ? 'ya' : 'tidak'"
                            :disabled="true"
                            />{{-- riwayat hipertensi --}}
                        </div>
                <div class="flex space-x-8">
                        <x-radiobutton
                            label="Kebiasaan Merokok"
                            name="kebiasaan_merokok"
                            :options="[
                                'Perokok pasif' => 'Perokok pasif',
                                'Perokok aktif' => 'Perokok aktif',
                                'Tidak merokok' => 'Tidak merokok'
                            ]"
                            :selected="$anamnesis->kebiasaan_merokok"
                            :disabled="true"
                            />  {{-- riwayat merokok --}}
                        <x-radiobutton
                            label="Riwayat Transfusi Darah"
                            name="transfusi"
                            :options="[
                                'ya' => 'Ya',
                                'tidak' => 'Tidak'
                            ]"
                            :selected="$anamnesis->transfusi == 1 ? 'ya' : 'tidak'"
                            :disabled="true"
                            />{{-- riwayat transfusi darah --}}
                        </div>
                <div class="flex justify-end m-4 col-span-2">
                    <div class="rounded-full p-2 px-2 bg-[#73946B] text-white">
                        <i class="fa-solid fa-pencil"></i>
                        <button id="editPasien" class="text-sm font-semibold">Edit Data</button>
                    </div>
                    <div class="rounded-full p-2 px-2 bg-[#73946B] text-white ml-4">
                        <i class="fa-solid fa-save"></i>
                        <button id="simpanPasien" class="text-sm font-semibold">Simpan Data</button>
                    </div>
                </div>
                </div>
                </div>
    <div class="flex justify-between my-4">
    <div>
    {{-- <form action="{{ route ('home') }}" method="GET" class="flex items-center gap-2 text-[#888888]" id="filterForm">
            <h3 class="text-m text-black">Filter Berdasarkan:</h3>
            <div class="rounded border p-1 px-2 hover:border-[#B0DB9C] ">
                <label for="tanggal" class="text-sm"></label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">
            </div>
            <div class="rounded border p-1 px-2 hover:border-[#B0DB9C]">
                <select name="status" id="status" class=" text-sm outline-none" >
                    <option value="Status Anemia" disabled selected>Status Anemia</option>
                    <option value="Normal" {{ request('status') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Anemia" {{ request('status') == 'Anemia' ? 'selected' : '' }}>Anemia</option>
                </select>
            </div>
        </form> --}}
    </div>
    <div class="flex justify-end m-4">
        <div class="rounded-full p-2 px-2 bg-[#73946B] text-white">
            <a href="/pasien-baru"><i class="fa-solid fa-plus"></i>
            <button class="text-sm font-semibold" >Tambah Data</button></a>
        </div>
    </div>
    </div>

<table class="min-w-full">
    <thead class="bg-[#B0DB9C] text-white rounded">
    <tr>
        <th class="p-3 text-center text-sm font-semibold w-[10%]">Tanggal</th>
        <th class="p-3 text-center text-sm font-semibold w-[35%]">Nama Pasien</th>
        <th class="p-3 text-center text-sm font-semibold w-[15%]">Saturasi Oksigen (%)</th>
        <th class="p-3 text-center text-sm font-semibold w-[15%]">Detak Jantung (bpm)</th>
        <th class="p-3 text-center text-sm font-semibold w-[20%]">Status Anemia</th>
    </thead>

    @foreach ($pemeriksaans as $pemeriksaan )
    <tbody>
    <tr class="odd:bg-gray-50 even:bg-white">
        <td class="p-3 text-center text-sm font-medium w-[10%]">{{$pemeriksaan->created_at->format('j / m / Y')}}</td>
        <td class="p-3 text-center text-sm font-medium w-[35%]">{{$pemeriksaan->pasien->name}}</td>
        <td class="p-3 text-center text-sm font-medium w-[15%]">{{$pemeriksaan->pemeriksaan->spo2}}</td>
        <td class="p-3 text-center text-sm font-medium w-[15%]">{{$pemeriksaan->pemeriksaan->heart_rate}}</td>
        <td class="p-3 text-center text-xs font-medium w-[20%%">@if ($pemeriksaan->pemeriksaan->status_anemia == 'Anemia') <x-anaemia-button></x-anaemia-button> @else <x-normal-button></x-normal-button>
        @endif</td>
    </tr>
    </tbody>
    @endforeach
</table>
</div>
</div>
<script>
document.getElementById('editPasien').addEventListener('click', function() {
    const form = document.getElementById('anamnesisForm');
    const isEditing = this.classList.toggle('editing');

    document.querySelectorAll('#anamnesisForm input, #anamnesisForm textarea').forEach(el => {
        el.disabled = !isEditing;
    });

    this.textContent = isEditing ? 'Simpan Perubahan' : 'Edit Data';
    if (!isEditing) form.submit(); // langsung submit ke route update
});

</script>
</x-layout>
