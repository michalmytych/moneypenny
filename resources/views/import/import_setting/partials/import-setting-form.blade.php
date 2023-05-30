<div class="px-8 pb-8 mb-4 flex flex-col">
    <h1 class="text-3xl font-bold mb-4">{{ __('Add new import settings') }}</h1>
    <form action="{{ route('import.import-setting.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            {{--@todo - no queries in templates--}}
            @if(\App\Models\Import\ColumnsMapping::whereUser(request()->user())->count() === 0 && \App\Models\Import\ImportSetting::whereUser(request()->user())->count() === 1)
                <a
                    class="font-semibold text-indigo-600 hover:text-indigo-400 flex items-center"
                    href="{{ route('import.columns-mapping.index') }}">
                    @include('icons.add') To upload first file, first you should create columns mapping configuration.
                </a>
            @endif
        </div>

        {{--@todo - fill all placeholders--}}
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="name">
                {{ __('Name') }}
            </label>
            @include('components.input.tip', ['key' => 'name', 'text' => __('Default name of the configuration')])
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="{{ __('Name') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="file_extension">
                {{ __('File extension') }}
            </label>
            @include('components.input.tip', ['key' => 'file_extension', 'text' => __('Extension of the imported file')])
            <select
                    id="file_extension"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="file_extension">
                <option value="csv" selected>csv</option>
                <option value="tsv">tsv</option>
                <option value="xls">xls</option>
                <option value="xlsx">xlsx</option>
            </select>
            <x-input-error :messages="$errors->get('file_extension')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="delimiter">
                {{ __('Separator') }}
            </label>
            @include('components.input.tip', ['key' => 'delimiter', 'text' => __('Data separator character (for *.csv files)')])
            <select
                    id="delimiter"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="delimiter">
                <option value="|">|</option>
                <option value="-">-</option>
                <option value=";">;</option>
                <option selected value=",">,</option>
            </select>
            <x-input-error :messages="$errors->get('delimiter')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="enclosure">
                {{ __('Enclosure') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'enclosure', 'text' => __('Enclosure - character limiting the data in the column (for text files)')])
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="enclosure" type="text" name="enclosure" placeholder="{{ __('Enclosure') }}">
            <x-input-error :messages="$errors->get('enclosure')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="start_row">
                {{ __('Start row') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'start_row', 'text' => __('The row where the data begins - indexing from zero')])
            <input type="number" min="0" max="1000" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start_row" name="start_row" value="0">
            <x-input-error :messages="$errors->get('start_row')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="escape_character">
                {{ __('Escape character') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'escape_character', 'text' => __('Escape character (for text files)')])
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="escape_character" type="text" name="escape_character" placeholder="{{ __('Escape character') }}">
            <x-input-error :messages="$errors->get('escape_character')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="input_encoding">
                {{ __('Input encoding') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'input_encoding', 'text' => __('The input encoding of the file. If the file is imported with the wrong encoding, the calculation results may be incorrect')])
            <select
                    id="input_encoding"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="input_encoding">
                {{--@todo resolve supported input eoncodings from config --}}
                <option value="UTF-8" selected>UTF-8</option>
                <option value="Windows-1250">Windows-1250</option>
            </select>
            <x-input-error :messages="$errors->get('input_encoding')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between">
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
            'file_extension',
            'delimiter',
            'enclosure',
            'start_row',
            'escape_character',
            'input_encoding'
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
                });
                nameTip.style.display = 'block';
            });
        });

        const nameInput = document.getElementById('name');
        nameInput.focus();
    });
</script>
