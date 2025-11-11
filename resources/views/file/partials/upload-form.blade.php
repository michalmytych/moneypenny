<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
    @csrf

    <div class="mb-3">
        {{-- @todo - no queries in templates --}}
        @if (\App\Models\Import\ImportSetting::whereUser(request()->user())->count() === 0)
            <a class="font-semibold text-indigo-600 hover:text-indigo-400 flex items-center"
                href="{{ route('import.import-setting.index') }}">
                @include('icons.add-indigo')
                <span class="ml-1">
                    {{ __('To upload first file, first you should create import configuration.') }}
                </span>
            </a>
        @endif
    </div>

    <div class="mb-3">
        {{-- @todo - no queries in templates --}}
        @if (\App\Models\Import\ColumnsMapping::whereUser(request()->user())->count() === 0)
            <a class="font-semibold text-indigo-600 hover:text-indigo-400 flex items-center"
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
        <select id="import_setting_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="import_setting_id" required>
            <option selected>{{ __('Select') }}</option>
            @foreach ($importSettings as $importSetting)
                <option value="{{ $importSetting->id }}">
                    {{ $importSetting->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('import_setting_id')" class="mt-2" />
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="columns_mapping_id">
            {{ __('Columns mappings') }}
        </label>
        <select id="columns_mapping_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="columns_mapping_id" required>
            <option selected>{{ __('Select') }}</option>
            @foreach ($columnsMappings as $columnMapping)
                <option value="{{ $columnMapping->id }}">
                    {{ $columnMapping->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('columns_mapping_id')" class="mt-2" />
    </div>
    <div class="mb-4">
        <input type="hidden" name="type" value="{{ \App\Models\File::TRANSACTIONS_IMPORT }}">
        <x-file-drop fileInputName="file" />

        <div class="mb-4 overflow-scroll">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">{{ __('Preview') }}</h3>

            <div class="mb-2 flex gap-2">
                <button type="button" id="toggleTable" class="text-indigo-600 hover:text-indigo-500 font-bold hover:underline">
                    {{ __('Show table') }}
                </button>
                <button type="button" id="toggleRaw" class="text-indigo-600 hover:text-indigo-500 font-bold hover:underline hidden">
                    {{ __('Show raw text') }}
                </button>
            </div>

            <div class="w-full">
                <div id="csvPreviewTable"
                    class="overflow-x-auto border rounded p-2 text-sm text-gray-700 bg-gray-50 hidden"></div>
                <pre id="csvPreviewRaw"
                    class="overflow-x-auto border rounded p-2 text-sm text-gray-700 bg-gray-50 whitespace-pre-wrap font-mono"></pre>
            </div>

        </div>

        <x-input-error :messages="$errors->get('file')" class="mt-2" />
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
                uploadButton.disabled = true;
                loaderWraper.style.visibility = 'visible';
            });
        });
    </script>

    <script>
        const toggleTableBtn = document.getElementById('toggleTable');
        const toggleRawBtn = document.getElementById('toggleRaw');
        const csvPreviewTable = document.getElementById('csvPreviewTable');
        const csvPreviewRaw = document.getElementById('csvPreviewRaw');

        document.getElementById('fileInputfile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                const text = event.target.result;
                csvPreviewRaw.textContent = text;
                csvPreviewRaw.classList.remove('hidden');
                csvPreviewTable.classList.add('hidden');
                toggleTableBtn.classList.remove('hidden');
                toggleRawBtn.classList.add('hidden');

                const rows = text
                    .trim()
                    .split('\n')
                    .map(row => row.split(';').map(cell => cell.trim()));

                if (rows.length === 0) return;

                const headers = rows[0];
                const data = rows.slice(1, 101);

                const table = document.createElement('table');
                table.className = 'min-w-full border-collapse text-sm text-gray-700';

                const thead = document.createElement('thead');
                const trHead = document.createElement('tr');
                headers.forEach(header => {
                    const th = document.createElement('th');
                    th.textContent = header;
                    th.className = 'border px-1 py-0.5 bg-gray-100 text-gray-600 font-semibold';
                    trHead.appendChild(th);
                });
                thead.appendChild(trHead);
                table.appendChild(thead);

                const tbody = document.createElement('tbody');
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.textContent = cell;
                        td.className = 'border px-2 py-1';
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });
                table.appendChild(tbody);

                csvPreviewTable.innerHTML = '';
                csvPreviewTable.appendChild(table);
            };

            reader.readAsText(file, 'windows-1250');
        });

        toggleTableBtn.addEventListener('click', () => {
            csvPreviewRaw.classList.add('hidden');
            csvPreviewTable.classList.remove('hidden');
            toggleTableBtn.classList.add('hidden');
            toggleRawBtn.classList.remove('hidden');
        });

        toggleRawBtn.addEventListener('click', () => {
            csvPreviewRaw.classList.remove('hidden');
            csvPreviewTable.classList.add('hidden');
            toggleTableBtn.classList.remove('hidden');
            toggleRawBtn.classList.add('hidden');
        });
    </script>
@endpush
