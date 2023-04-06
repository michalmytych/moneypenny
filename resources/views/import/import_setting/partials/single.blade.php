<div class="bg-white px-8 pt-6 pb-8 mb-4">
    <h2 class="text-3xl font-medium mb-4">Ustawienia importu {{ $importSetting->name }}</h2>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Nazwa:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->name }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Rozszerzenie pliku:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->file_extension }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Separator:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->delimiter }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Obejmowanie:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->enclosure ?? '-' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Znak escape:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->escape_character ?? '-' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            Kodowanie wejściowe:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->input_encoding ?? '-' }}
        </p>
    </div>
    <div class="flex items-center justify-between">
        <a href="{{ route('import.import-setting.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Powrót
        </a>
    </div>
</div>
