<x-app-layout>
    <div class="pb-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid gap-4 lg:grid-cols-2 md:grid-cols-1">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white">
                                <h2 class="text-xl font-bold mb-2 flex items-baseline justify-between">
                                    <span>Directory Size</span>
                                    <small class="text-sm text-gray-500">{{ data_get($meta, 'directory') }}</small>
                                </h2>
                                <p class="text-gray-600">{{ data_get($meta, 'directory_size.folder_size', 'N/A') }}B</p>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white">
                                <h2 class="text-xl font-bold mb-2">Disk Free</h2>
                                <p class="text-gray-600">{{ data_get($meta, 'disk_free.disk_free', 'N/A') }}B</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm mt-4 sm:rounded-lg">
                        <div class="p-6 bg-white">
                            <h2 class="text-xl font-bold mb-2">System Info</h2>
                            @include('meta.partials.system-info', ['meta' => $meta])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
