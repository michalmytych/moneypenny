<x-app-layout>
    <div class="pb-64">
        <div class="w-full mx-auto">
            <div class="py-10">
                <div class="mx-auto sm:px-6 lg:px-8 py-8">

                    <h2 class="text-black font-bold text-2xl pb-4">{{ __('Devices') }}</h2>

                    @include('auth.partials.devices-list', ['devices' => $devices])

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

