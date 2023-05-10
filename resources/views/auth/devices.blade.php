<x-app-layout>
    <div class="pb-64">
        <div class="w-full mx-auto">
            <div class="py-10">
                <div class="mx-auto sm:px-6 lg:px-8 py-8">

                    <h2 class="text-black font-bold text-2xl pb-4">Urządzenia</h2>

                    <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-1">
                        @foreach($devices as $device)
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h2m10-7h2a2 2 0 012 2v10a2 2 0 01-2 2h-2m-6-10h4a2 2 0 012 2v12a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    {{ $device->device_type }}
                                                </dt>
                                                <dd class="mt-1 text-lg font-semibold text-gray-900">
                                                    {{ $device->ip }}
                                                </dd>
                                                <dd class="mt-1 text-sm text-gray-500 truncate">
                                                    {{ $device->created_at->diffForHumans() }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

