<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('institution.partials.institutions-list', ['institution' => $institutions])

        </div>
    </div>
</x-guest-layout>
