<div class="pb-36">
    <a href="{{ route('user.index') }}" class="text-indigo-600 font-bold">
        {{ __('Back') }}
    </a>
    <h1 class="text-4xl mt-4 font-semibold">{{ __('User') }} {{ $user->name }}</h1>

    <h2 class="text-2xl font-semibold mt-4">{{ __('Data') }}</h2>
    <div class="overflow-x-scroll rounded-md pt-4 w-full">
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Selected calcuation currency') }}
            </div>
            <div>
                {{ $baseCurrencyCode }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Transaction count') }}
            </div>
            <div>
                {{ $transactionsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Transactions imports count') }}
            </div>
            <div>
                {{ $importsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Import settings count') }}
            </div>
            <div>
                {{ $importSettingsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Columns mappings count') }}
            </div>
            <div>
                {{ $columnsMappingsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('End user agreements count') }}
            </div>
            <div>
                {{ $endUserAgreementsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Requisitions count') }}
            </div>
            <div>
                {{ $requisitionsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Nordigen accounts count') }}
            </div>
            <div>
                {{ $nordigenAccountsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
        <div class="flex items-center justify-between">
            <div class="font-semibold text-gray-600">
                {{ __('Synchronizations count') }}
            </div>
            <div>
                {{ $synchronizationsCount }}
            </div>
        </div>
        <div class="w-full h-px bg-gray-300 mb-4"></div>
    </div>

    <h2 class="text-2xl font-semibold mb-4 mt-4">{{ __('Devices used by ') }} {{ $user->name }}</h2>
    @include('auth.partials.devices-list', ['devices' => $devices])
</div>
