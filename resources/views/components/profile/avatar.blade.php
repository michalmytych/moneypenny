@php
    $width = '40';
    $height = '40';

    /** @var string $variant */
    if (isset($variant) && strtolower($variant) === 'xl') {
        $width = '140';
        $height = '140';
    }
@endphp

<div class="w-fit h-fit rounded-full">
    <img
{{--        src="{{ $src ?? '' }}"--}}
    src="placeholders/avatar_placeholder.jpeg"
        alt="User avatar image"
        width="{{ $width }}"
        height="{{ $height }}"
        style="border-radius: 50%;"
    >
</div>
