@php
    $width = '40';
    $height = '40';
    $componentId = \Illuminate\Support\Str::uuid();
    $placeholderUrl = asset('placeholders/avatar_placeholder.jpeg');
    $loadingPlaceholderUrl = asset('placeholders/loading_placeholder.jpeg');

    /** @var string $variant */
    if (isset($variant) && strtolower($variant) === 'xl') {
        $width = '140';
        $height = '140';
    }
@endphp

<div class="w-full h-fit rounded-full hoverScaleBox">
    <img
        id="{{ $componentId }}"
        data-src="{{ $src ?? '' }}"
        data-placeholderSrc="{{ $placeholderUrl }}"
        src="{{ $loadingPlaceholderUrl }}"
        alt="User avatar image"
        width="{{ $width }}"
        height="{{ $height }}"
        style="border-radius: 50%; aspect-ratio: 1 / 1; margin: 0 auto;"
    >
</div>

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            const avatarImage = document.getElementById("{{ $componentId }}");

            const fadeInImage = () => {
                avatarImage.classList.remove('fade-in');
                avatarImage.classList.add('fade-in');
            }

            avatarImage.onerror = () => {
                fadeInImage();
                avatarImage.setAttribute('src', "{{ $placeholderUrl }}");
            };

            fadeInImage();
            avatarImage.setAttribute('src', "{{ (string) $src }}");
        });
    </script>
@endpush
