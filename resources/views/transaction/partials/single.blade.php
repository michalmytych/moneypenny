<div class="bg-white px-8 pt-6 pb-8 mb-4 rounded-md">
    <div class="font-semibold text-indigo-500">
        <a href="{{ route('transaction.index') }}">Back</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 mb-6">

        <div>
            <div class="mb-4 mt-2">
                <p class="block text-gray-700 font-bold mb-2">
                    Volume (as used for calculations):
                </p>
                <p class="text-gray-700 text-7xl">
                    {{ $transaction->{\App\Models\Transaction\Transaction::CALCULATION_COLUMN} ?? 'No data' }} <span class="text-xl">{{ $transaction->currency }}</span>
                </p>
            </div>
            <div class="mb-4 mt-2">
                <p class="block text-gray-700 font-bold mb-2">
                    Volume (raw from data source):
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->raw_volume ?? 'No data' }} <span class="text-xl">{{ $transaction->currency }}</span>
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Sender:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->sender ?? 'No data'  }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Receiver:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->receiver ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Description:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->description ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Transaction date:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->transaction_date ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Accounting date:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->accounting_date ?? 'No data' }}
                </p>
            </div>
        </div>

        <div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Sender account number:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->sender_account_number ?? 'No data'  }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Receiver account number:
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->receiver_account_number ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Sender persona (auto):
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->senderPersona?->common_name ?? 'No data' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="block text-gray-700 font-bold mb-2">
                    Receiver persona (auto):
                </p>
                <p class="text-gray-700 text-xl">
                    {{ $transaction->receiverPersona?->common_name ?? 'No data' }}
                </p>
            </div>

        </div>

    </div>
</div>

<h2 class="text-black font-bold text-2xl pb-4">Similar transactions</h2>
<div class="pb-20">
    @include('transaction.partials.transactions-list', ['transactions' => $similarTransactions])
</div>
