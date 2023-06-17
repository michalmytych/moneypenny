<details class="mt-2" data-source="{{ $url }}">
    <summary class="transition bg-gray-100 shadow-sm hover:bg-gray-200 rounded-md cursor-pointer directory-details"
             data-source="{{ $url }}"
             style="min-width: 250px;">
        <div class="p-2 pl-3 font-semibold text-gray-700 flex items-center">
            <div class="text-gray-400">
                @include('icons.sm.folder')
            </div>
            <span class="ml-2">{{ $directoryName }}</span>
        </div>
    </summary>
    <div class="flex items-center p-2 loadingState">
        <span>
            @include('icons.loader-sm')
        </span>
        <span class="ml-2 text-gray-500">
            Loading...
        </span>
    </div>
</details>

