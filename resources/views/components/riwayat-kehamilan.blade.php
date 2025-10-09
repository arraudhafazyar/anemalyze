
<div class="space-y-2">
    <p class="font-medium mt-4">Riwayat kehamilan</p>
    <form action="{{ route('anamnesis.store') }}" method="POST">
        @csrf
        <div class="flex space-x-6">
            <label class="flex items-center space-x-2 cursor-pointer">
            <input type="radio" name="riwayat" value="Nulligravida" class="hidden peer"/>
            <span class="w-6 h-6 rounded-full border border-gray-400 bg-gray-200 peer-checked:bg-[#B0DB9C]"></span>
            <span>Nulligravida</span>
            </label>

            <label class="flex items-center space-x-2 cursor-pointer">
            <input type="radio" name="riwayat" value="Primigravida" class="hidden peer" />
            <span class="w-6 h-6 rounded-full border border-gray-400 bg-gray-200 peer-checked:bg-[#B0DB9C]"></span>
            <span>Primigravida</span>

            <label class="flex items-center space-x-2 cursor-pointer">
            <input type="radio" name="riwayat" value="Multigravida" class="hidden peer" />
            <span class="w-6 h-6 rounded-full border border-gray-400 bg-gray-200 peer-checked:bg-[#B0DB9C]"></span>
            <span>Multigravida</span>
            </label>
        </div>
    </form>
</div>
