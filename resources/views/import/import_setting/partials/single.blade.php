<div class="bg-white px-8 pt-6 pb-8 mb-4">
    <h2 class="text-3xl font-medium mb-4">Ustawienia importu {{ $importSetting->name }}</h2>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            {{ __('Name') }}:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->name }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            {{ __('File extension') }}:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->file_extension }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            {{ __('Separator') }}:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->delimiter }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            {{ __('Enclosure') }}:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->enclosure ?? '-' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            {{ __('Escape character') }}:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->escape_character ?? '-' }}
        </p>
    </div>
    <div class="mb-4">
        <p class="block text-gray-700 font-bold mb-2">
            {{ __('Input encoding') }}:
        </p>
        <p class="text-gray-700">
            {{ $importSetting->input_encoding ?? '-' }}
        </p>
    </div>
    <x-back-link/>
</div>
