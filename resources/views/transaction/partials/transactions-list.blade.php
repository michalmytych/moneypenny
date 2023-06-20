@if(count($transactions) > 0)
    <div class="overflow-x-scroll rounded-md">
        <table class="divide-y divide-gray-200 min-w-full">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Transaction Date') }}
                </th>
                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Category') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Volume') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Description') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Receiver') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($transactions as $transaction)
                <tr class="hover:bg-gray-50 cursor-pointer transaction-row"
                    data-url="{{ route('transaction.show', ['id' => $transaction->id]) }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $transaction->transaction_date->format('d.m.Y') }}
                    </td>
                    <td class="py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center text-gray-500">
                            @if($transaction->created_at->gt(now()->subMinutes(2)))
                                <div class="flex items-center w-fit">
                                    @include('icons.loader-sm')
                                    <div class="ml-2">
                                        Categorizing
                                    </div>
                                </div>
                            @else
                                @if($transaction->category)
                                    <div class="w-4 h-4 rounded-full shadow pt-1 bg-indigo-500"
                                         @if($transaction->category->color_hex)
                                             style="background-color: {{ $transaction->category->color_hex }};"
                                        @endif
                                    ></div>
                                    <div class="ml-3">{{ $transaction->category->name }}</div>
                                @else
                                    <div class="bg-gray-200 w-4 h-4 rounded-full shadow pt-1"></div>
                                    <div class="ml-3">-</div>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <strong>{{ $transaction->raw_volume }}</strong> {{ $transaction->currency }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->description ?? '-') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \App\Services\Helpers\StringHelper::shortenAuto($transaction->receiver ?? '-') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h2 class="font-semibold text-xl">{{ __('No transactions') }}</h2>
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
