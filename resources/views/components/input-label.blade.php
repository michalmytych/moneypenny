@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    @if($attributes->get('required'))
        <span class="relative">
            <span class="absolute -left-[0.6rem] -top-[0.2rem] text-red-500 font-bold text-lg">*</span>
        </span>
    @endif
    {{ $value ?? $slot }}
</label>
