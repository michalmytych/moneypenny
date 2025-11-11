<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div>
                @include('import.import_setting.partials.import-setting-form', ['importSetting' => $importSetting])
            </div>

        </div>
    </div>
</x-app-layout>
