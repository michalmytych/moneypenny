<div class="px-8 pb-8 mb-4 flex flex-col">
    @if(isset($importSetting))
        <h1 class="text-3xl font-bold mb-4">{{ __('Editing import settings') }}</h1>
    @else
        <h1 class="text-3xl font-bold mb-4">{{ __('Add new import settings') }}</h1>
    @endif
    <form
        action="{{ isset($importSetting) ? route('import.import-setting.update', ['id' => $importSetting->id]) : route('import.import-setting.create')}}"
        method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            @if(!$columnConfigurationExist)
                <a
                    class="font-semibold text-indigo-600 hover:text-indigo-400 flex items-center"
                    href="{{ route('import.columns-mapping.index') }}">
                    @include('icons.add-indigo')
                    <span class="ml-1">
                        {{ __('You need to add columns configuration') }}
                    </span>
                </a>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="name">
                {{ __('Name') }}
            </label>
            @include('components.input.tip', ['key' => 'name', 'text' => __('Default name of the configuration')])
            <input
                value="{{ isset($importSetting) ? $importSetting->name : '' }}"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="name" type="text" name="name" placeholder="{{ __('Name') }}">
            <x-input-error :messages="$errors->get('name')"
                           class="mt-2"/>
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
                @foreach(config('import-settings.supported_extensions', []) as $extension)
                    @if(isset($importSetting) && $importSetting->file_extension === $extension)
                        <option selected value="{{ $extension }}">{{ $extension }}</option>
                    @else
                        <option value="{{ $extension }}">{{ $extension }}</option>
                    @endif
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('file_extension')" class="mt-2"/>
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
                @foreach(config('import-settings.supported_delimiters', []) as $delimiter)
                    @if(isset($importSetting) && $importSetting->delimiter === $delimiter)
                        <option selected value="{{ $delimiter }}">{{ $delimiter }}</option>
                    @else
                        <option value="{{ $delimiter }}">{{ $delimiter }}</option>
                    @endif
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('delimiter')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="enclosure">
                {{ __('Enclosure') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'enclosure', 'text' => __('Enclosure - character limiting the data in the column (for text files)')])
            <input
                value="{{ isset($importSetting) ? $importSetting->enclosure : '' }}"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="enclosure" type="text" name="enclosure" placeholder="{{ __('Enclosure') }}">
            <x-input-error :messages="$errors->get('enclosure')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="start_row">
                {{ __('Start row') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'start_row', 'text' => __('The row where the data begins - indexing from zero')])
            <input type="number" min="0" max="1000"
                   value="{{ isset($importSetting) ? $importSetting->start_row : 0 }}"
                   class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   id="start_row" name="start_row">
            <x-input-error :messages="$errors->get('start_row')" class="mt-2"/>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="escape_character">
                {{ __('Escape character') }} <small>{{ __('(optional)') }}</small>
            </label>
            @include('components.input.tip', ['key' => 'escape_character', 'text' => __('Escape character (for text files)')])
            <input
                value="{{ isset($importSetting) ? $importSetting->start_row : '' }}"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="escape_character" type="text" name="escape_character" placeholder="{{ __('Escape character') }}">
            <x-input-error :messages="$errors->get('escape_character')" class="mt-2"/>
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
                @foreach(config('import-settings.supported_encodings', []) as $encoding)
                    @if(isset($importSetting) && $importSetting->input_encoding === $encoding)
                        <option selected value="{{ $encoding }}">{{ $encoding }}</option>
                    @else
                        <option value="{{ $encoding }}">{{ $encoding }}</option>
                    @endif
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('input_encoding')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
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
