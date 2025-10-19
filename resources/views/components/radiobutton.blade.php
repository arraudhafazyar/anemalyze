@props(['label', 'name', 'options' => [], 'selected' => null, 'disabled' => false])

<div class="space-y-2">
    <p class="font-medium mt-4">{{ $label }}</p>
    <div class="flex space-x-10">
        @foreach($options as $value => $text)
            <label id="anamnesisForm" class="flex items-center space-x-2 cursor-pointer">
                <input
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    class="hidden peer"
                    @if($selected == $value) checked @endif
                    @if($disabled) disabled @endif
                />
                <span class="w-6 h-6 rounded-full border border-gray-400 bg-gray-200 peer-checked:bg-[#B0DB9C]"></span>
                <span>{{ $text }}</span>
            </label>
        @endforeach
    </div>
</div>
