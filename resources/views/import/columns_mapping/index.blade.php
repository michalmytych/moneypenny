<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('import.columns_mapping.partials.columns-mapping-form')

            @include('import.columns_mapping.partials.columns-mapping-list', ['columnsMappings' => $columnsMappings])

        </div>
    </div>
</x-guest-layout>
