<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @foreach($agreements as $agreement)
                @include('nordigen.end_user_agreements.partials.single-with-requisitions', ['agreement' => $agreement, 'institution' => $institution])
            @endforeach

        </div>
    </div>
</x-guest-layout>
