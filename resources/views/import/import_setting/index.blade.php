<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="lg:grid grid-cols-[2fr_3fr]">
                <div>
                    @include('import.import_setting.partials.import-setting-form')
                </div>
                <div>
                    <h2 class="text-3xl font-semibold mb-4">Ustawienia importów</h2>
                    @include('import.import_setting.partials.import-setting-list', ['importSettings' => $importSettings])
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
