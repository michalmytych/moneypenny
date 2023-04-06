<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('import.import_setting.partials.import-setting-form')

            @include('import.import_setting.partials.import-setting-list', ['importSettings' => $importSettings])

        </div>
    </div>
</x-guest-layout>
