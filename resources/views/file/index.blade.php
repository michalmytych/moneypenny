<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="lg:grid grid-cols-[1fr_2fr]">
                <div>
                    <h2 class="text-3xl font-semibold mb-4">Przesyłanie</h2>
                    @include('file.partials.upload-form', ['importSettings' => $importSettings])
                </div>
                <div>
                    @include('file.partials.files-list', ['files' => $files])
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
