<nav class="w-full bg-white rounded-lg shadow-md">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-black hover:text-indigo-700 font-bold" style="font-family: 'Fraunces', serif;">
                        moneypenny
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('transaction.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Transakcje</a>
                        <a href="{{ route('institution.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Integracje</a>
                        <a href="{{ route('file.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Pliki</a>
                        <a href="{{ route('synchronization.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Synchronizacje</a>
                        <a href="{{ route('import.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Importy</a>
                        <a href="{{ route('import.import-setting.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Ustawienia importów</a>
                        <a href="{{ route('import.columns-mapping.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Mapowanie kolumn</a>
                        <a href="{{ route('debug.analyzers') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Debugowanie analizatorów</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
