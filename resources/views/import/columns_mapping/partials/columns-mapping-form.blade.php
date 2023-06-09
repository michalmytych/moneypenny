<div class="px-8 pb-24">
    <h1 class="text-3xl font-bold mb-4">{{ __('Create new column mapping') }}</h1>
    <form action="{{ route('import.columns-mapping.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Name') }}
            </label>
            @include('components.input.tip', ['key' => 'name', 'text' => __('Provide a name for this column mapping')])
            <input type="text" name="name" id="name"
                   class="form-input block w-full rounded-md shadow-sm @error('name') border-red-500 @enderror"
                   value="{{ old('name', $columnsMapping->name ?? '') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <div class="mb-4">
            <label for="transaction_date_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Transaction Date Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'transaction_date_column_index', 'text' => __('Transaction date column number, starting from zero')])
            <input type="number" name="transaction_date_column_index" id="transaction_date_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('transaction_date_column_index') border-red-500 @enderror"
                   value="{{ old('transaction_date_column_index', $columnsMapping->transaction_date_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('transaction_date_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="accounting_date_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Accounting Date Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'accounting_date_column_index', 'text' => __('Column number with accounting date starting from zero')])
            <input type="number" name="accounting_date_column_index" id="accounting_date_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('accounting_date_column_index') border-red-500 @enderror"
                   value="{{ old('accounting_date_column_index', $columnsMapping->accounting_date_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('accounting_date_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="sender_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Sender Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'sender_column_index', 'text' => __('Column number with the name of the sender of the transaction, counting from zero')])
            <input type="number" name="sender_column_index" id="sender_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('sender_column_index') border-red-500 @enderror"
                   value="{{ old('sender_column_index', $columnsMapping->sender_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('sender_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="receiver_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Receiver Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'receiver_column_index', 'text' => __('Column number with the name of the receiver of the transaction, counting from zero')])
            <input type="number" name="receiver_column_index" id="receiver_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('receiver_column_index') border-red-500 @enderror"
                   value="{{ old('receiver_column_index', $columnsMapping->receiver_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('receiver_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="description_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Description Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'description_column_index', 'text' => __('Transaction description column number, starting from zero')])
            <input type="number" name="description_column_index" id="description_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('description_column_index') border-red-500 @enderror"
                   value="{{ old('description_column_index', $columnsMapping->description_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('description_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="volume_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Volume Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'volume_column_index', 'text' => __('Column number with the value of the transaction, counting from zero')])
            <input type="number" name="volume_column_index" id="volume_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('volume_column_index') border-red-500 @enderror"
                   value="{{ old('volume_column_index', $columnsMapping->volume_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('volume_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="currency_column_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Currency Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'currency_column_index', 'text' => __('Transaction currency column number, starting from zero')])
            <input type="number" name="currency_column_index" id="currency_column_index"
                   class="form-input block w-full rounded-md shadow-sm @error('currency_column_index') border-red-500 @enderror"
                   value="{{ old('currency_column_index', $columnsMapping->currency_column_index ?? '') }}">
            <x-input-error :messages="$errors->get('currency_column_index')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label for="sender_account_number_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Sender Account Number Column Index') }}
            </label>
            @include('components.input.tip', ['key' => 'sender_account_number_index', 'text' => __('Column number with the number of the sending account, counting from zero')])
            <input type="number" name="sender_account_number_index" id="sender_account_number_index"
                   class="form-input block w-full rounded-md shadow-sm @error('sender_account_number_index') border-red-500 @enderror"
                   value="{{ old('sender_account_number_index', $columnsMapping->sender_account_number_index ?? '') }}">
            <x-input-error :messages="$errors->get('sender_account_number_index')" class="mt-2"/>
        </div>
        <div class="mb-4">
            <label for="receiver_account_number_index" class="form-label block font-medium text-gray-700 mb-1">
                {{ __('Receiver Account Number Index') }}
            </label>
            @include('components.input.tip', ['key' => 'receiver_account_number_index', 'text' => __("Column number with the recipient's account number, counting from zero")])
            <input type="number" name="receiver_account_number_index" id="receiver_account_number_index"
                   class="form-input block w-full rounded-md shadow-sm @error('receiver_account_number_index') border-red-500 @enderror"
                   value="{{ old('receiver_account_number_index', $columnsMapping->receiver_account_number_index ?? '') }}">
            <x-input-error :messages="$errors->get('receiver_account_number_index')" class="mt-2"/>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>

<script>
    /** @todo - This could be a separate component, working with tip.blade.php component */

    window.addEventListener('load', () => {
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
                const allLabels = document.querySelectorAll('.form-label');
                allLabels.forEach(label => {
                    label.style.fontWeight = 'regular';
                    if (label.getAttribute('for') === key) {
                        label.style.fontWeight = 'bolder';
                    }
                });
                nameTip.style.display = 'block';

                const allTips = document.querySelectorAll("div[id$='_tip']");
                allTips.forEach(tip => {
                    tip.style.display = 'none';
                    tip.classList.remove('fade-in');
                });
                nameTip.style.display = 'block';
                nameTip.classList.add('fade-in');
            });
        });

        const nameInput = document.getElementById('name');
        nameInput.focus();
    });
</script>
