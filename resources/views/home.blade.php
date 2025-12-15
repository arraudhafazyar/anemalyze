<x-layout :title="$title">
<div class="flex justify-between items-center m-4">
    <img src="/img/anemalayze-high-resolution-logo-transparent.png" alt="Logo Anemalyze" class="w-50">
    <form action="/home" method="get">
        @csrf
        @if (request('pemeriksaan.pasien.name'))
            <input type="hidden" name="name" value="{{ request('pemeriksaan.pasien.name') }}">
        @endif
            <div class="rounded-full bg-gray-50 border border-[#888888] p-1 px-2.5 outline:none">
                <i class="fas fa-search text-[#888888] mr-1"></i>
                <label for="search" class="form-label"></label>
                <input type="text" class="form-control text-sm outline-none pr-52" placeholder="cari nama pasien" id="search" name="search">
            </div>
    </form>
        <form action="{{ route ('home') }}" method="GET" class="flex items-center gap-2 text-[#888888]" id="filterForm">
            <h3 class="text-m text-black">Filter Berdasarkan:</h3>
            <div class="rounded border p-1 px-2 hover:border-[#E43636] ">
                <label for="tanggal" class="text-sm"></label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">
            </div>
            <div class="rounded border p-1 px-2 hover:border-[#E43636]">
                <select name="status" id="status" class=" text-sm outline-none" >
                    <option value="Status Anemia" disabled selected>Status Anemia</option>
                    <option value="Normal" {{ request('status') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Anemia" {{ request('status') == 'Anemia' ? 'selected' : '' }}>Anemia</option>
                </select>
            </div>
        </form>
        <form action="{{ route ('logout') }}" method="POST" class="flex items-start gap-2 text-[#888888] mr-2">
            @csrf
            <button type="submit" class="rounded border p-1 px-2 hover:border-[#E43636]">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </form>
</div>
</div>
<div class="flex justify-end m-4">
    <div class="rounded-full p-2 px-2 bg-[#CD5656] text-white">
        <a href="/pasien-baru"><i class="fa-solid fa-plus"></i>
        <button class="text-sm font-semibold">Pasien Baru</button></a>
    </div>
</div>
<div class="m-4">
<table class="min-w-full">
    <thead class="bg-[#E43636] text-white">
    <tr>
        <th class="p-3 text-center text-sm font-semibold w-[10%]">Tanggal</th>
        <th class="p-3 text-center text-sm font-semibold w-[35%]">Nama Pasien</th>
        <th class="p-3 text-center text-sm font-semibold w-[15%]">Saturasi Oksigen (%)</th>
        <th class="p-3 text-center text-sm font-semibold w-[15%]">Detak Jantung (bpm)</th>
        <th class="p-3 text-center text-sm font-semibold w-[20%]">Status Anemia</th>
        <th class="p-3 text-center text-sm font-semibold w-[5%]">Detail</th>
    </thead>
    @forelse ($pemeriksaans as $pemeriksaan )
    <tbody>
    <tr class="odd:bg-gray-50 even:bg-white">
        <td class="p-3 text-center text-sm font-medium w-[10%]">{{ $pemeriksaan->created_at->format('j / m / Y') }}</td>
        <td class="p-3 text-center text-sm font-medium w-[35%]">{{ $pemeriksaan->pasien->name}}</td>
        <td class="p-3 text-center text-sm font-medium w-[15%]">{{ $pemeriksaan->spo2 }}</td>
        <td class="p-3 text-center text-sm font-medium w-[15%]">{{ $pemeriksaan->heart_rate }}</td>
        <td class="p-3 text-center text-xs font-medium w-[20%%">@if ($pemeriksaan->status_anemia == 'Anemia') <x-anaemia-button></x-anaemia-button> @else <x-normal-button></x-normal-button>
        @endif</td>
        <td class="p-3 text-center text-sm font-medium w-[5%] text-gray-500"> <a href="/home/{{ $pemeriksaan->pasien->slug }}/{{ $pemeriksaan->anamnesis_id }}"><i class="fa-solid fa-circle-info"></i></a></td>
    </tr>
    </tbody>
    @empty
    <div class="flex flex-col justify-center items-center mb-4">
    <p class="font-semibold text-2xl my-4">Data tidak ditemukan</p>
    <a href="/home" class="block text-blue-600 hover:underline">&laquo; Back to home</a>
    </div>
    @endforelse

</table>
    <div class="mt-4">{{ $pemeriksaans->links() }}</div>
</div>
<script>
    document.querySelectorAll('#filterForm input, #filterForm select').forEach(el => {
        el.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });
</script>


</x-layout>
