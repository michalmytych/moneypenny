<details class="mt-2">
    <summary class="transition bg-white shadow-sm hover:bg-indigo-100 rounded-md cursor-pointer directory-details"
             data-source="{{ $url }}"
             data-name="{{ $directoryName }}"
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

