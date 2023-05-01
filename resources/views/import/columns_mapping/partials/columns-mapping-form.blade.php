<div class="px-8 pb-24">
    <h1 class="text-3xl font-bold mb-4">Dodaj mapowanie kolumn</h1>
    <form action="{{ route('import.columns-mapping.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700 mb-1">
                Name
            </label>
            @include('components.input.tip', ['key' => 'name', 'text' => __('Podaj nazwę dla tego mapowania kolumn')])
            <input type="text" name="name" id="name"
                   class="form-input block w-full rounded-md shadow-sm @error('name') border-red-500 @enderror"
                   value="{{ old('name', $columnsMapping->name ?? '') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <div class="mb-4">
            <label for="transaction_date_column_index" class="block font-medium text-gray-700 mb-1">
                Transaction Date Column Index
            </label>
            @include('components.input.tip', ['key' => 'transaction_date_column_index', 'text' => __('Numer kolumny z datą transakcji, licząc od zera')])
            <input type="number" name="transaction_date_column_index" id="transaction_date_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('transaction_date_column_index') border-red-500 @enderror"
                   value="{{ old('transaction_date_column_index', $columnsMapping->transaction_date_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('transaction_date_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="accounting_date_column_index" class="block font-medium text-gray-700 mb-1">
                Accounting Date Column Index
            </label>
            @include('components.input.tip', ['key' => 'accounting_date_column_index', 'text' => __('Numer kolumny z datą zaksięgowania, licząc od zera')])
            <input type="number" name="accounting_date_column_index" id="accounting_date_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('accounting_date_column_index') border-red-500 @enderror"
                   value="{{ old('accounting_date_column_index', $columnsMapping->accounting_date_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('accounting_date_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="sender_column_index" class="block font-medium text-gray-700 mb-1">
                Sender Column Index
            </label>
            @include('components.input.tip', ['key' => 'sender_column_index', 'text' => __('Numer kolumny z nazwą nadawcy transakcji, licząc od zera')])
            <input type="number" name="sender_column_index" id="sender_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('sender_column_index') border-red-500 @enderror"
                   value="{{ old('sender_column_index', $columnsMapping->sender_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('sender_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="receiver_column_index" class="block font-medium text-gray-700 mb-1">
                Receiver Column Index
            </label>
            @include('components.input.tip', ['key' => 'receiver_column_index', 'text' => __('Numer kolumny z nazwą odbiorcy transakcji, licząc od zera')])
            <input type="number" name="receiver_column_index" id="receiver_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('receiver_column_index') border-red-500 @enderror"
                   value="{{ old('receiver_column_index', $columnsMapping->receiver_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('receiver_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="description_column_index" class="block font-medium text-gray-700 mb-1">
                Description Column Index
            </label>
            @include('components.input.tip', ['key' => 'description_column_index', 'text' => __('Numer kolumny z opisem transakcji, licząc od zera')])
            <input type="number" name="description_column_index" id="description_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('description_column_index') border-red-500 @enderror"
                   value="{{ old('description_column_index', $columnsMapping->description_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('description_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="volume_column_index" class="block font-medium text-gray-700 mb-1">
                Volume Column Index
            </label>
            @include('components.input.tip', ['key' => 'volume_column_index', 'text' => __('Numer kolumny z wartością transakcji, licząc od zera')])
            <input type="number" name="volume_column_index" id="volume_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('volume_column_index') border-red-500 @enderror"
                   value="{{ old('volume_column_index', $columnsMapping->volume_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('volume_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="currency_column_index" class="block font-medium text-gray-700 mb-1">
                Currency Column Index
            </label>
            @include('components.input.tip', ['key' => 'currency_column_index', 'text' => __('Numer kolumny z walutą transakcji, licząc od zera')])
            <input type="number" name="currency_column_index" id="currency_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('currency_column_index') border-red-500 @enderror"
                   value="{{ old('currency_column_index', $columnsMapping->currency_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('currency_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="sender_account_number_index" class="block font-medium text-gray-700 mb-1">
                Sender Account Number Column Index
            </label>
            @include('components.input.tip', ['key' => 'sender_account_number_index', 'text' => __('Numer kolumny z numerem konta wysyłającego, licząc od zera')])
            <input type="number" name="sender_account_number_index" id="sender_account_number_index"
                   class="form-input block w-full rounded-md shadow-sm @error('sender_account_number_index') border-red-500 @enderror"
                   value="{{ old('sender_account_number_index', $columnsMapping->sender_account_number_index ?? '') }}">
            <x-input-error :messages="$errors->get('sender_account_number_index')" class="mt-2"/>
        </div>
        <div class="mb-4">
            <label for="receiver_account_number_index" class="block font-medium text-gray-700 mb-1">
                Receiver Account Number Index
            </label>
            @include('components.input.tip', ['key' => 'receiver_account_number_index', 'text' => __('Numer kolumny z numerem konta odbiorcy, licząc od zera')])
            <input type="number" name="receiver_account_number_index" id="receiver_account_number_index"
                   class="form-input block w-full rounded-md shadow-sm @error('receiver_account_number_index') border-red-500 @enderror"
                   value="{{ old('receiver_account_number_index', $columnsMapping->receiver_account_number_index ?? '') }}">
            <x-input-error :messages="$errors->get('receiver_account_number_index')" class="mt-2"/>
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
            Zapisz
        </button>
    </form>
</div>

<script>
    /** @todo - This could be a separate component, working with tip.blade.php component */

    const tippedInputsIds = [
        'name',
        'transaction_date_column_index',
        'accounting_date_column_index',
        'sender_column_index',
        'receiver_column_index',
        'description_column_index',
        'volume_column_index',
        'currency_column_index',
        'sender_account_number_index',
        'receiver_account_number_index'
    ];

    tippedInputsIds.forEach(key => {
        const input = document.getElementById(key);
        const nameTip = document.getElementById(`${key}_tip`);
        input.addEventListener('focus', () => {
            console.log(nameTip.innerText)
            const allTips = document.querySelectorAll("div[id$='_tip']");
            allTips.forEach(tip => {
                tip.style.display = 'none';
            });
            nameTip.style.display = 'block';
        });
    });
</script>
