<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('file.partials.upload-form')

            @include('file.partials.files-list', ['files' => $files])

        </div>
    </div>
</x-guest-layout>
