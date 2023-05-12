@php
    $releaseNotes = config('release_notes.list');
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @foreach($releaseNotes as $note)
                <div class="px-6 py-6 bg-white rounded-md mb-6">
                    <div class="mb-2">
                        <div class="flex items-center">
                            <h2 class="text-4xl font-bold text-black">{{ $note['header'] }}</h2>
                        </div>
                        <span class="flex items-center text-lg text-gray-500 font-light cursor-pointer mt-4">
                            @include('icons.calender-empty')
                            <span class="relative" style="top: 1px;">{{ $note['date'] }}</span>
                        </span>
                    </div>
                    <div class="mt-4">
                        <ul>
                             @foreach($note['notes'] as $text)
                                 <li class="flex items-center">
                                     @include('icons.check')
                                     <span class="ml-1">{{ $text }}</span>
                                 </li>
                             @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
