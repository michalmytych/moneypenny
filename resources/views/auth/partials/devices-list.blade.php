<div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-1">
    @foreach($devices as $device)
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-gray-500">
                        @include('icons.device')
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ $device->device_type }}
                            </dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $device->ip }}
                            </dd>
                            <dd class="mt-1 text-sm truncate text-green-700">
                                {{ $device->created_at->diffForHumans() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
