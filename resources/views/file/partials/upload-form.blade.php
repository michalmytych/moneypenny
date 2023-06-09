<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
    @csrf

    <div class="mb-3">
        {{--@todo - no queries in templates--}}
        @if(\App\Models\Import\ImportSetting::whereUser(request()->user())->count() === 0)
            <a
                class="font-semibold text-indigo-600 hover:text-indigo-400 flex items-center"
                href="{{ route('import.import-setting.index') }}">
                @include('icons.add-indigo')
                <span class="ml-1">
                    {{ __('To upload first file, first you should create import configuration.') }}
                </span>
            </a>
        @endif
    </div>

    <div class="mb-3">
        {{--@todo - no queries in templates--}}
        @if(\App\Models\Import\ColumnsMapping::whereUser(request()->user())->count() === 0)
            <a
                class="font-semibold text-indigo-600 hover:text-indigo-400 flex items-center"
                href="{{ route('import.columns-mapping.index') }}">
                @include('icons.add-indigo')
                <span class="ml-1">
                    {{ __('To upload first file, first you should create columns mapping configuration.') }}
                </span>
            </a>
        @endif
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="import_setting_id">
            {{ __('Import settings') }}
        </label>
        <select
            id="import_setting_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="import_setting_id" required>
            <option selected>{{ __('Select') }}</option>
            @foreach($importSettings as $importSetting)
                <option value="{{ $importSetting->id }}">
                    {{ $importSetting->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('import_setting_id')" class="mt-2"/>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="columns_mapping_id">
            {{ __('Columns mappings') }}
        </label>
        <select
            id="columns_mapping_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="columns_mapping_id" required>
            <option selected>{{ __('Select') }}</option>
            @foreach($columnsMappings as $columnMapping)
                <option value="{{ $columnMapping->id }}">
                    {{ $columnMapping->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('columns_mapping_id')" class="mt-2"/>
    </div>
    <div class="mb-4">
        <x-file-drop fileInputName="file"/>
        <x-input-error :messages="$errors->get('file')" class="mt-2"/>
    </div>
    <div class="flex justify-end">
        <div class="flex items-center gap-1 ml-3" id="loaderWraper" style="visibility: hidden;">
            @include('icons.loader') <span class="text-gray-600 mr-6">{{ __('Processing...') }}</span>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg"
                id="uploadButton">
            {{ __('Upload') }}
        </button>
    </div>
</form>

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            const uploadForm = document.getElementById('uploadForm');
            const uploadButton = document.getElementById('uploadButton');
            const loaderWraper = document.getElementById('loaderWraper');
            uploadForm.addEventListener('submit', () => {
                uploadButton.disabled = 'true';
                loaderWraper.style.visibility = 'visible';
            });
        });
    </script>
@endpush
