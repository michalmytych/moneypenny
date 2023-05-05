@if(count($transactions) > 0)
    <div class="overflow-x-scroll rounded-md">
        <table class="divide-y divide-gray-200 min-w-full">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Transaction Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Volume
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Description
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Receiver
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($transactions as $transaction)
                <tr class="hover:bg-gray-100 cursor-pointer transaction-row"
                    data-url="{{ route('transaction.show', ['id' => $transaction->id]) }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->transaction_date->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <strong>{{ $transaction->raw_volume }}</strong> {{ $transaction->currency }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->description ?? '-', 45) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->receiver ?? '-', 30) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-xl">Brak transakcji</h2>
@endif

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            const transactionRows = document.querySelectorAll('.transaction-row');
            transactionRows.forEach(row => {
                row.addEventListener('click', () => {
                    window.location.href = row.dataset.url;
                });
            });
        });
    </script>
@endpush
