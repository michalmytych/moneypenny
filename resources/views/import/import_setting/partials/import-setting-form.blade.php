<div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
    <h1 class="text-3xl font-bold mb-4">Dodaj ustawienia importu</h1>
    <form action="{{ route('import.import-setting.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="name">
                Nazwa
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Nazwa">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="file_extension">
                Rozszerzenie pliku
            </label>
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
                Separator
            </label>
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
                Enclosure <small>(opcjonalne)</small>
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="enclosure" type="text" name="enclosure" placeholder="Enclosure">
            <x-input-error :messages="$errors->get('enclosure')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="start_row">
                Wiersz rozpoczynający <small>(opcjonalne)</small>
            </label>
            <input type="number" min="0" max="1000" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start_row" name="start_row" value="0">
            <x-input-error :messages="$errors->get('start_row')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="escape_character">
                Znak escape <small>(opcjonalne)</small>
            </label>
            <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="escape_character" type="text" name="escape_character" placeholder="Znak escape">
            <x-input-error :messages="$errors->get('escape_character')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="input_encoding">
                Kodowanie wejściowe <small>(opcjonalne)</small>
            </label>
            <select
                    id="input_encoding"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="input_encoding">
                <option value="UTF-8" selected>UTF-8</option>
                <option value="Windows-1250">Windows-1250</option>
            </select>
            <x-input-error :messages="$errors->get('input_encoding')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg">
                Zapisz
            </button>
        </div>
    </form>
</div>
