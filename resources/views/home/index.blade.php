@push('styles')
    <style>
        body {
            overflow: hidden;
        }
    </style>
@endpush

<x-app-layout>
    <div class="py-16 w-full mx-auto">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('home.partials.available-actions', ['transactionsData' => $transactionsData])

            @include('home.partials.header', [ 'saldoData' => $saldoData ])

            @include('home.partials.latest-transactions', ['transactionsData' => $transactionsData ])

        </div>
    </div>
</x-app-layout>
