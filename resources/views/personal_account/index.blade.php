<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('personal_account.partials.personal-accounts-list', ['personalAccounts' => $personalAccounts])

        </div>
    </div>
</x-app-layout>
