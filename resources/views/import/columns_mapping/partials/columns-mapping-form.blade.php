<div class="px-8 ">
    <h1 class="text-3xl font-bold mb-4">Dodaj mapowanie kolumn</h1>
    <form action="{{ route('import.columns-mapping.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700 mb-1">
                Name
            </label>
            <input type="text" name="name" id="name"
                   class="form-input block w-full rounded-md shadow-sm @error('name') border-red-500 @enderror"
                   value="{{ old('name', $columnsMapping->name ?? '') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <div class="mb-4">
            <label for="transaction_date_column_index" class="block font-medium text-gray-700 mb-1">
                Transaction Date Column Index
            </label>
            <input type="number" name="transaction_date_column_index" id="transaction_date_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('transaction_date_column_index') border-red-500 @enderror"
                   value="{{ old('transaction_date_column_index', $columnsMapping->transaction_date_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('transaction_date_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="accounting_date_column_index" class="block font-medium text-gray-700 mb-1">
                Accounting Date Column Index
            </label>
            <input type="number" name="accounting_date_column_index" id="accounting_date_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('accounting_date_column_index') border-red-500 @enderror"
                   value="{{ old('accounting_date_column_index', $columnsMapping->accounting_date_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('accounting_date_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="sender_column_index" class="block font-medium text-gray-700 mb-1">
                Sender Column Index
            </label>
            <input type="number" name="sender_column_index" id="sender_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('sender_column_index') border-red-500 @enderror"
                   value="{{ old('sender_column_index', $columnsMapping->sender_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('sender_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="receiver_column_index" class="block font-medium text-gray-700 mb-1">
                Receiver Column Index
            </label>
            <input type="number" name="receiver_column_index" id="receiver_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('receiver_column_index') border-red-500 @enderror"
                   value="{{ old('receiver_column_index', $columnsMapping->receiver_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('receiver_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="description_column_index" class="block font-medium text-gray-700 mb-1">
                Description Column Index
            </label>
            <input type="number" name="description_column_index" id="description_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('description_column_index') border-red-500 @enderror"
                   value="{{ old('description_column_index', $columnsMapping->description_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('description_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="volume_column_index" class="block font-medium text-gray-700 mb-1">
                Volume Column Index
            </label>
            <input type="number" name="volume_column_index" id="volume_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('volume_column_index') border-red-500 @enderror"
                   value="{{ old('volume_column_index', $columnsMapping->volume_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('volume_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="currency_column_index" class="block font-medium text-gray-700 mb-1">
                Currency Column Index
            </label>
            <input type="number" name="currency_column_index" id="currency_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('currency_column_index') border-red-500 @enderror"
                   value="{{ old('currency_column_index', $columnsMapping->currency_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('currency_column_index')" class="mt-2"/>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
            Zapisz
        </button>
    </form>
</div>
