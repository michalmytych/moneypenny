<nav class="w-full bg-white shadow-sm">
    <div class="px-16 mx-auto">
        <div class="flex items-center justify-between h-16">
              <div class="ml-10 flex items-center space-x-2">
                  <a href="{{ route('transaction.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Transakcje</a>
                  <a href="{{ route('institution.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Integracje</a>
                  <a href="{{ route('file.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Pliki</a>
                  <a href="{{ route('synchronization.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Synchronizacje</a>
                  <a href="{{ route('import.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Importy</a>
                  <a href="{{ route('import.import-setting.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Ustawienia importów</a>
                  <a href="{{ route('import.columns-mapping.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Mapowanie kolumn</a>
                  <a href="{{ route('debug.analyzers') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Debugowanie analizatorów</a>
                  <a href="{{ route('meta.index') }}" class="text-black hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-bold">Meta</a>
              </div>
        </div>
    </div>
</nav>
