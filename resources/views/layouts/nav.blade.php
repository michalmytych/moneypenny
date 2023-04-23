<nav class="w-full bg-white shadow-sm">
    <div class="px-16 mx-auto">
        <div class="flex items-center justify-between h-16">
              <div class="ml-10 flex items-center space-x-2">
                  <a href="{{ route('transaction.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Transakcje</a>
                  <a href="{{ route('institution.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Integracje</a>
                  <a href="{{ route('file.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Pliki</a>
                  <a href="{{ route('synchronization.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Synchronizacje</a>
                  <a href="{{ route('import.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Importy</a>
                  <a href="{{ route('import.import-setting.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Ustawienia importów</a>
                  <a href="{{ route('import.columns-mapping.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Mapowanie kolumn</a>
                  <a href="{{ route('debug.analyzers') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Debugowanie analizatorów</a>
                  <a href="{{ route('meta.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Meta</a>
              </div>
        </div>
    </div>
</nav>
