<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('import.partials.imports-list', ['imports' => $imports])

        </div>
    </div>
</x-guest-layout>
