<x-app-layout>
    <div class="pt-6 pb-8 w-full mx-auto">
        <div class="w-full mx-auto px-4 lg:px-8 pb-20">

            @include('home.partials.available-actions', ['transactionsData' => $transactionsData])

            @include('home.partials.header', [
                'saldoData' => $saldoData,
                'budgetsWithConsumption' => $budgetsWithConsumption,
                'eventNotifications' => $eventNotifications
            ])

            @include('home.partials.latest-transactions', ['transactionsData' => $transactionsData ])

        </div>
    </div>
</x-app-layout>
