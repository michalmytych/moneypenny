<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <details class="mb-2">
                <summary class="mb-2">
                    <span class="flex items-center hover:text-gray-600 font-semibold cursor-pointer">
                        @include('icons.add-indigo')
                        <span class="ml-1">Add new cash transaction</span>
                    </span>
                </summary>
                @include('transaction.partials.transaction-form', ['personas' => $personas])
            </details>

            @include('transaction.partials.filters-bar', [
                'filterableColumns' => $filterableColumns,
                'route' => route('transaction.index')
            ])

            @include('transaction.partials.transactions-list', ['transactions' => $transactions])

        </div>
    </div>
</x-app-layout>
