@php
    /** @var string $userUploadedAvatar */
    $avatars = [
        ['src' => $userUploadedAvatar, 'server_path' => null],
        ['src' => asset('placeholders/avatar_placeholder.jpeg'), 'server_path' => 'placeholders/avatar_placeholder.jpeg'],
        ['src' => asset('placeholders/avatar_placeholder_2.jpeg'), 'server_path' => 'placeholders/avatar_placeholder_2.jpeg'],
        ['src' => asset('placeholders/avatar_placeholder_3.jpeg'), 'server_path' => 'placeholders/avatar_placeholder_3.jpeg'],
        ['src' => asset('placeholders/avatar_placeholder_4.jpeg'), 'server_path' => 'placeholders/avatar_placeholder_4.jpeg'],
        ['src' => asset('placeholders/avatar_placeholder_5.jpeg'), 'server_path' => 'placeholders/avatar_placeholder_5.jpeg'],
        ['src' => asset('placeholders/avatar_placeholder_6.jpeg'), 'server_path' => 'placeholders/avatar_placeholder_6.jpeg']
    ];
@endphp

<div class="absolute top-40 bg-white p-10 rounded-xl shadow-2xl" style="left: 22%;">
    <div class="flex z-50 items-center">
        @foreach($avatars as $avatar)
            <div class="mx-4">
                <div class="w-full h-fit rounded-full shadow-md hoverScaleBox
                    @if($avatar['src'] === $userUploadedAvatar)
                        border-4 border-indigo-500 p-1
                    @endif
                ">
                    <img
                        class="libraryAvatar"
                        data-src="{{ $avatar['src'] ?? '' }}"
                        data-serverpath="{{ $avatar['server_path'] }}"
                        src="{{ $avatar['src'] }}"
                        alt="Library avatar image"
                        width="70"
                        height="70"
                        style="border-radius: 50%; aspect-ratio: 1 / 1; margin: 0 auto;"
                    >
                </div>
            </div>
        @endforeach
    </div>
</div>
