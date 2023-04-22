<x-app-layout>
    <div class="py-12">
        <div class="w-3/4 mx-auto sm:px-6 lg:px-8">

            @include('import.import_setting.partials.single', ['importSetting' => $importSetting])

        </div>
    </div>
</x-app-layout>
