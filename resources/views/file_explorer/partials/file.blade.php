<div class="mt-2 transition bg-white hover:bg-indigo-100 rounded-md cursor-pointer file-details"
         style="min-width: 250px;" data-source="{{ route('file_explorer.show', ['path' => $filePath]) }}">
    <div class="p-2 pl-3 font-semibold text-gray-700 flex items-center">
        <div class="text-gray-400">
            @include('icons.sm.files')
        </div>
        <span class="ml-2">{{ $file }}</span>
    </div>
</div>
