<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @if(count($agreements) > 0)
                @include('nordigen.end_user_agreements.partials.end-user-agreements-list', ['agreements' => $agreements])
            @endif

            @include('nordigen.institution.partials.institutions-list', ['institution' => $institutions])

        </div>
    </div>
</x-guest-layout>
