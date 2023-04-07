<x-guest-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('transaction.partials.transactions-list', ['transactions' => $transactions])

        </div>
    </div>
</x-guest-layout>
