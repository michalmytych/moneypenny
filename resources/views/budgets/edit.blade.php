<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('budgets.partials.budget-form', ['budget' => $budget])

        </div>
    </div>
</x-app-layout>
