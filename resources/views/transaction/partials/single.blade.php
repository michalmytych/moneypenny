<div class="bg-white px-8 pt-6 pb-8 mb-4 rounded-md">
    <x-back-link/>

    <div class="grid grid-cols-1 lg:grid-cols-2 mb-6">
        <div>
            <div class="mb-4 mt-2">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Volume (as used for calculations)') }}:
                </p>
                <p class="text-gray-700 font-bold text-7xl">
                    {{ $transaction->{\App\Moneypenny\Transaction\Models\Transaction::CALCULATION_COLUMN} ?? 'No data' }}
                    <span
                            class="text-xl">{{ $userBaseCurrency }}</span>
                </p>
            </div>
            <div class="mb-4 mt-2">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Volume (raw from data source)') }}:
                </p>
                <p class="text-gray-700 text-4xl font-bold">
                    {{ $transaction->raw_volume ?? 'No data' }} <span
                            class="text-xl">{{ $transaction->currency }}</span>
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Category') }}:
                </p>
                <p class="text-gray-700 text-xl">
                @if($transaction->created_at->gt(now()->subMinutes(10)))
                    <div class="flex items-center w-fit">
                        @include('icons.loader-sm')
                        <div class="ml-2">
                            Categorizing
                        </div>
                    </div>
                @else
                    @if($transaction->category)
                        <details>
                            <summary class="flex items-center">
                                @include('components.category.category-badge', ['name' => $transaction->category->name])
                            </summary>
                            <div class="mt-4">
                                @include('transaction.partials.transaction-category-form', [
                                    'transaction' => $transaction,
                                ])
                            </div>
                        </details>
                        @else
                            @include('transaction.partials.transaction-category-form', [
                                'transaction' => $transaction,
                            ])
                        @endif
                        @endif
                        </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Sender') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->sender ?? 'No data'  }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Receiver') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->receiver ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Description') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->description ?? 'No data' }}
                </p>
            </div>
        </div>

        <div>
            <div class="mb-2">
                @include('transaction.partials.exclude-from-calculation-form', ['transaction' => $transaction])
            </div>
            <h2 class="text-black font-bold text-2xl pb-4">{{ __('Details') }}</h2>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Transaction date') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->transaction_date ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Accounting date') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->accounting_date ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Sender account number') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->sender_account_number ?? 'No data'  }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Receiver account number') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->receiver_account_number ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Sender persona (auto)') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->senderPersona?->common_name ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Receiver persona (auto)') }}:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->receiverPersona?->common_name ?? 'No data' }}
                </p>
            </div>

        </div>

    </div>
</div>

<h2 class="text-black font-bold text-2xl pb-4">{{ __('Similar transactions') }}</h2>
<div class="pb-20">
    @include('transaction.partials.transactions-list', ['transactions' => $similarTransactions])
</div>

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            const categoryForm = document.getElementById('categoryForm');
            const categoryInput = document.getElementById('category_id');

            categoryInput.addEventListener('change', () => {
                categoryForm.submit();
            });
        });
    </script>
@endpush
