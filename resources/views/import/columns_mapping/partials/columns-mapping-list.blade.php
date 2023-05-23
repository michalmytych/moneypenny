@if(count($columnsMappings) > 0)
    <div class="overflow-x-scroll rounded-md shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Transaction date') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Accounting date') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sender') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Receiver') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sender account number') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Receiver account number') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Volume') }}</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Currency') }}</th>
                <th class="px-6 py-3 bg-gray-50"></th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($columnsMappings as $columnsMapping)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->transaction_date_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->accounting_date_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->sender_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->receiver_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->sender_account_number_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->receiver_account_number_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->description_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->volume_column_index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $columnsMapping->currency_column_index }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-xl">{{ __('No columns mappings') }}</h2>
@endif
