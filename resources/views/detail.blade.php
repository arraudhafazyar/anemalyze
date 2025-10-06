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
                    <textarea name="keluhan" id="keluhan" class="w-full h-32  rounded-lg shadow-xl bg-[#B0DB9C] p-3 active:border-none text-sm">whiaefiwaeo</textarea>
                    <div class="flex space-x-16 mb-4">
                    <x-riwayat-kehamilan></x-riwayat-kehamilan>
                    <x-takikardia></x-takikardia> <x-hipertensi> </x-hipertensi></div>
                <div class="flex space-x-8">
                    <x-kebiasaan-merokok></x-kebiasaan-merokok>
                    <x-transfusi-darah></x-transfusi-darah> </div>
                <div class="flex justify-end m-4 col-span-2">
                    <div class="rounded-full p-2 px-2 bg-[#73946B] text-white">
                        <i class="fa-solid fa-pencil"></i>
                        <button class="text-sm font-semibold">Edit Data</button>
                    </div>
                </div>
                </div>
                </div>
    <div class="flex justify-between mb-4">
    <div>
    <div class="flex items-center gap-2 text-[#888888] mt-4">
        <h3 class="text-m text-black">Filter Berdasarkan:</h3>
            <div class="rounded border p-1 px-2">
                <button type="date" class="text-sm font-light ">Tanggal</button>
                <i class="fa-solid fa-circle-chevron-down"></i></div>
            <div class="rounded border p-1 px-2">
                <button class="text-sm font-light " >Status Anemia</button>
                <i class="fa-solid fa-circle-chevron-down"></i></div>
    </div>
    </div>
    <div class="flex justify-end mb-4">
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
        <th class="p-3 text-center text-sm font-semibold w-[5%]">Detail</th>
    </thead>
    <tbody>
    <tr class="odd:bg-gray-50 even:bg-white">
        <td class="p-3 text-center text-sm font-medium w-[10%]">25/09/2025</td>
        <td class="p-3 text-center text-sm font-medium w-[35%]">Budi Santoso</td>
        <td class="p-3 text-center text-sm font-medium w-[15%]">97</td>
        <td class="p-3 text-center text-sm font-medium w-[15%]">78</td>
        <td class="p-3 text-center text-xs font-medium w-[20%%"><x-normal-button></x-normal-button></td>
        <td class="p-3 text-center text-sm font-medium w-[5%] text-gray-500"> <i class="fa-solid fa-circle-info"></i></td>
    </tr>   
    </tbody>
</table>
</div>  
</div>
</x-layout>