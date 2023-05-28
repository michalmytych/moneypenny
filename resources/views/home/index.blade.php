@push('styles')
    <style>
        body {
            overflow: hidden;
        }

        @media (max-width: 800px) {
            body {
                overflow: scroll;
            }
        }
    </style>
@endpush

<x-app-layout>
    <div class="py-16 w-full mx-auto">
        <div class="w-full mx-auto px-4 lg:px-8">

            @include('home.partials.available-actions', ['transactionsData' => $transactionsData])

            @include('home.partials.header', [ 'saldoData' => $saldoData, 'budgetsWithConsumption' => $budgetsWithConsumption ])

            @include('home.partials.latest-transactions', ['transactionsData' => $transactionsData ])

        </div>
    </div>
</x-app-layout>
