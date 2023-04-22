<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div class="lg:grid grid-cols-[1fr_2fr]">
                <div>
                    @include('import.columns_mapping.partials.columns-mapping-form')
                </div>
                <div class="lg:ml-4">
                    <h2 class="text-3xl font-semibold mb-4">Mapowania kolumn</h2>
                    @include('import.columns_mapping.partials.columns-mapping-list', ['columnsMappings' => $columnsMappings])
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
