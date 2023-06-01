<x-app-layout>
    <div class="py-8">
        <div class="w-3/4 mx-auto sm:px-6 lg:px-8">

            @include('admin.partials.single', [
                'user' => $user,
                'devices' => $devices,
                'baseCurrencyCode' => $baseCurrencyCode,
                'transactionsCount' => $transactionsCount,
                'importsCount' => $importsCount,
                'importSettingsCount' => $importSettingsCount,
                'columnsMappingsCount' => $columnsMappingsCount,
                'endUserAgreementsCount' => $endUserAgreementsCount,
                'requisitionsCount' => $requisitionsCount,
                'nordigenAccountsCount' => $nordigenAccountsCount,
                'synchronizationsCount' => $synchronizationsCount
            ])

        </div>
    </div>
</x-app-layout>
