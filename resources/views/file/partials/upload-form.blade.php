<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="import_setting_id">
            Ustawienia importu
        </label>
        <select
                id="import_setting_id"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="import_setting_id">
            <option selected>Wybierz</option>
            @foreach($importSettings as $importSetting)
                <option value="{{ $importSetting->id }}">
                    {{ $importSetting->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('import_setting_id')" class="mt-2" />
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="columns_mapping_id">
            Mapowanie kolumn
        </label>
        <select
                id="columns_mapping_id"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="columns_mapping_id">
            <option selected>Wybierz</option>
            @foreach($columnsMappings as $columnMapping)
                <option value="{{ $columnMapping->id }}">
                    {{ $columnMapping->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('columns_mapping_id')" class="mt-2" />
    </div>
    <div class="mb-4">
        <label for="file" class="block font-bold">Wybierz plik do przesłania</label>
        <input type="file" name="file" id="file" class="px-4 py-2 rounded-lg w-full">
        <x-input-error :messages="$errors->get('file')" class="mt-2" />
    </div>
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
        Prześlij
    </button>
</form>
