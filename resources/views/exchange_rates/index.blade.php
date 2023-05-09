<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('exchange_rates.partials.exchange-rates-list', ['exchangeRates' => $exchangeRates])

        </div>
    </div>
</x-app-layout>
