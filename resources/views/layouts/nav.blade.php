<nav class="bg-white rounded-lg">
    <div class="mx-auto px-4 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="text-black hover:text-indigo-600 font-bold">
                        MONEYPENNY
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('file.index') }}" class="text-black hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Pliki</a>
                        <a href="{{ route('import.index') }}" class="text-black hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Importy</a>
                        <a href="{{ route('import.import-setting.index') }}" class="text-black hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Ustawienia importów</a>
                        <a href="{{ route('import.columns-mapping.index') }}" class="text-black hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Mapowanie kolumn</a>
                        <a href="{{ route('transaction.index') }}" class="text-black hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Transakcje</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
