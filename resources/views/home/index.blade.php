@push('styles')
    <style>
        body {
            overflow: hidden;
        }
    </style>
@endpush

<x-app-layout>
    <div class="py-8 w-3/4 mx-auto">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('home.partials.header')

            @include('home.partials.latest-transactions', ['transactionsData' => $transactionsData ])

        </div>
    </div>
</x-app-layout>
