<div class="bg-white px-8 pt-6 pb-8 mb-4 rounded-md">
    <div class="font-semibold text-indigo-500">
        <a href="{{ route('transaction.index') }}">{{ __('Back') }}</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 mb-6">

        <div>
            <div class="mb-4 mt-2">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Volume (as used for calculations)') }}:
                </p>
                <p class="text-gray-700 text-7xl">
                    {{ $transaction->{\App\Models\Transaction\Transaction::CALCULATION_COLUMN} ?? 'No data' }} <span class="text-xl">{{ $userBaseCurrency }}</span>
                </p>
            </div>
            <div class="mb-4 mt-2">
                <p class="block text-gray-700 font-bold mb-2">
                    {{ __('Volume (raw from data source)') }}:
                </p>
                <p class="text-gray-700 text-4xl font-bold">
                    {{ $transaction->raw_volume ?? 'No data' }} <span class="text-xl">{{ $transaction->currency }}</span>
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
        </div>

        <div>
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
