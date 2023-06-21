<nav class="mx-auto rounded-lg bg-white shadow-sm">
    <div class="mx-auto">
        <div class="flex items-center justify-between h-16">
              <div class="flex items-center space-x-2 ml-5">
                  <a href="{{ route('file.index') }}" class="text-gray-500 hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Pliki</a>
                  <a href="{{ route('synchronization.index') }}" class="text-gray-500 hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Synchronizacje</a>
                  <a href="{{ route('persona.index') }}" class="text-gray-500 hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Podmioty</a>
                  <a href="{{ route('import.import-setting.index') }}" class="text-gray-500 hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Ustawienia importów</a>
                  <a href="{{ route('import.columns-mapping.index') }}" class="text-gray-500 hover:bg-gray-100 active:bg-gray-200 px-3 py-2 text-center rounded-md text-sm font-medium">Mapowanie kolumn</a>
              </div>
        </div>
    </div>
</nav>
