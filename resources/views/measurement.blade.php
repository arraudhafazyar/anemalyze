
<x-layout :title="$title">
    <div class="m-4">
        <h2 class="rounded-lg bg-[#73946B] text-white font-semibold p-2 px-6 my-4 ">Data Diri Pasien</h2>
        <form id="pemeriksaanForm" action="{{ route('pemeriksaan.store', $pasien->slug) }}" method="POST">
            @csrf
        <div class="mx-4 grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label for="nama">Nama Pasien</label>
                <input type="text" id="nama" name="nama" class="bg-[#ebe6e6] rounded-full px-3 py-2"  value="{{ $pasien->name }}" disabled>
            </div>
            <div class="flex flex-col">
                <label for="phone-number">Nomor Telepon</label>
                <input type="text" id="phone-number" name="phone-number" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->phone_number }}" disabled>
            </div>
        </div>
        <div class="mx-4 grid grid-cols-2 mt-4 gap-4">
            <div class="flex flex-col">
                <label for="placeborn">Tempat lahir</label>
                <input type="text" id="placeborn" name="placeborn" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->tempat_lahir}}" disabled>
            </div>
            <div class="flex flex-col">
                <label for="birthdate">Tanggal Lahir</label>
                <input type="date" id="birthdate" name="birthdate" class="bg-[#ebe6e6] rounded-full px-3 py-2" value="{{ $pasien->tanggal_lahir }}" disabled>
            </div>
            </div>
        </div>
    <h2 class="rounded-lg bg-[#73946B] text-white font-semibold p-2 px-6 my-4 m-4">Riwayat kesehatan</h2>
        <div class="mx-8 mt-4 grid grid-cols-2 gap-4">
            <div class="flex flex-col col-span-2">
                <label for="detail">Detail anamnesis</label>
                <textarea type="text" id="detail" name="detail" class="bg-[#ebe6e6] rounded-full px-3 py-2">{{ $anamnesis->keluhan }}</textarea>
            </div>
        </div>
        <div class="mx-8">
            <div class="flex space-x-20 flex-wrap mb-4">
                <x-radiobutton label="Riwayat Kehamilan"
                            name="kehamilan"
                            :options="[
                                'Nulligravida' => 'Nulligravida',
                                'Primigravida' => 'Primigravida',
                                'Multigravida' => 'Multigravida'
                            ]"
                            {{-- :selected="$anamnesis->kehamilan"
                            :disabled="true" --}}
                        />{{-- riwayat kehamilan --}}
                        <x-radiobutton
                        label="Riwayat Takikardia"
                        name="takikardia"
                        :options="[
                            'ya' => 'Ya',
                            'tidak' => 'Tidak'
                        ]"
                        {{-- :selected="$anamnesis->takikardia == 1 ? 'ya' : 'tidak'"
                        :disabled="true" --}}
                        /> {{-- riwayat takikardia --}}
                        <x-radiobutton
                            label="Riwayat Hipertensi"
                            name="hipertensi"
                            :options="[
                                'ya' => 'Ya',
                                'tidak' => 'Tidak'
                            ]"
                            {{-- :selected="$anamnesis->hipertensi == 1 ? 'ya' : 'tidak'"
                            :disabled="true" --}}
                            />{{-- riwayat hipertensi --}}
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
                            {{-- :selected="$anamnesis->kebiasaan_merokok"
                            :disabled="true" --}}
                            />  {{-- riwayat merokok --}}
                        <x-radiobutton
                            label="Riwayat Transfusi Darah"
                            name="transfusi"
                            :options="[
                                'ya' => 'Ya',
                                'tidak' => 'Tidak'
                            ]"
                            {{-- :selected="$anamnesis->transfusi == 1 ? 'ya' : 'tidak'"
                            :disabled="true" --}}
                            />{{-- riwayat transfusi darah --}}
                </div>
            </div>
                <div class="flex justify-end m-4">
                    <div class="rounded-full p-2 px-2 bg-[#73946B] text-white">
                        <i class="fa-solid fa-save"></i>
                        <button class="text-sm font-semibold">Simpan Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</x-layout>
