<x-app-layout>
    <div class="pb-64">
        <div class="w-full mx-auto">
            <div class="py-4">
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="grid gap-4 lg:grid-cols-2 md:grid-cols-1">
                        <div class="bg-white overflow-hidden sm:rounded-lg">
                            <div class="p-6 bg-white shadow-sm">
                                <h2 class="text-xl font-bold mb-2">Directories Size</h2>
                                @foreach(data_get($meta, 'directories_sizes') as $directory => $size)
                                    <div class="flex items-baseline justify-between">
                                        <p class="text-gray-500">{{ $directory }}</p>
                                        <p class="text-black">{{ data_get($size, 'folder_size') }}B</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="overflow-hidden rounded-lg grid grid-cols-1">
                            <div class="p-6 bg-white rounded-lg shadow-sm">
                                <h2 class="text-xl font-bold mb-2">Disk Free</h2>
                                <div class="flex items-baseline justify-between">
                                    <p class="text-gray-500">local</p>
                                    <p class="text-black">{{ data_get($meta, 'disk_free.disk_free', 'N/A') }}B</p>
                                </div>
                            </div>
                            <div class="p-6 bg-white rounded-lg mt-4 shadow-sm">
                                <h2 class="text-xl font-bold mb-2">Processes</h2>
                                @include('meta.partials.processes', ['processes' => data_get($meta, 'top')])
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 lg:grid-cols-2 md:grid-cols-1 mt-3">
                        <div class="bg-white overflow-hidden sm:rounded-lg">
                            <div class="p-6 bg-white overflow-x-scroll">
                                <h2 class="text-xl font-bold mb-2">System Info</h2>
                                @include('meta.partials.system-info', ['meta' => $meta])
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden sm:rounded-lg">
                            <div class="p-6 bg-white">
                                <h2 class="text-xl font-bold mb-2">Database tables sizes</h2>
                                @include('meta.partials.database-tables-sizes', ['tablesData' => data_get($meta, 'database.tables_sizes')])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
