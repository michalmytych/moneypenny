<div class="bg-white px-8 pt-6 pb-8 mb-4">
    <div class="font-semibold text-indigo-500">
        <a href="{{ url()->previous() }}">Back</a>
    </div>
    <div class="mb-4 mt-2">
        <p class="block text-gray-700 font-bold mb-2">
            Wartość:
        </p>
        <p class="text-gray-700 text-5xl">
            {{ $transaction->raw_volume ?? 'Brak danych' }} <span class="text-xl">{{ $transaction->currency }}</span>
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Nadawca:
        </p>
        <p class="text-gray-700">
            {{ $transaction->sender ?? 'Brak danych'  }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Odbiorca:
        </p>
        <p class="text-gray-700">
            {{ $transaction->receiver ?? 'Brak danych' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Opis transakcji:
        </p>
        <p class="text-gray-700">
            {{ $transaction->description ?? 'Brak danych' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Data wykonania transakcji:
        </p>
        <p class="text-gray-700">
            {{ $transaction->transaction_date ?? 'Brak danych' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Data zaksięgowania transakcji:
        </p>
        <p class="text-gray-700">
            {{ $transaction->accounting_date ?? 'Brak danych' }}
        </p>
    </div>
    <div class="flex items-center justify-between">
        <a href="{{ route('transaction.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Powrót
        </a>
    </div>
</div>
