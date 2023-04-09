@if(count($transactions) > 0)
    <table class="w-full divide-y divide-gray-200 overflow-x-scroll">
        <thead class="bg-gray-50 rounded-t-md">
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
                    Sender
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Receiver
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 overflow-x-scroll">
            @foreach ($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->transaction_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <strong>{{ $transaction->raw_volume }}</strong> {{ $transaction->currency }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->description ?? '-', 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->sender ?? '-', 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->receiver ?? '-', 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('transaction.show', ['id' => $transaction->id]) }}">
                            @include('icons.go')
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="font-semibold text-xl">Brak transakcji</h2>
@endif
