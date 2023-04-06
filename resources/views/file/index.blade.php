<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-3/4 mx-auto sm:px-6 lg:px-8">

            @include('file.partials.upload-form')

            @include('file.partials.files-list', ['files' => $files])

        </div>
    </div>
</x-guest-layout>
