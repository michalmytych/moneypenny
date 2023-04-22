<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('transaction.partials.filters-bar', [
                'filterableColumns' => $filterableColumns,
                'route' => route('transaction.index')
            ])

            @include('transaction.partials.transactions-list', ['transactions' => $transactions])

        </div>
    </div>
</x-app-layout>
