@if(count($transactions) > 0)
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    ID
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Transaction Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Accounting Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Sender
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Receiver
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Description
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Currency
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->transaction_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->accounting_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->sender }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->receiver }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->currency }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="font-semibold text-xl">Brak transakcji</h2>
@endif
