<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="lg:grid grid-cols-[1fr_1fr]">
                <div>
                    <h2 class="text-3xl font-bold mb-4">
                        {{ __('Uploading transactions files') }}
                    </h2>
                    @include('file.partials.upload-form', ['importSettings' => $importSettings])
                </div>
                <div>
                    @include('file.partials.files-list', ['files' => $files])
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
