<x-guest-layout>
    <div class="py-12">
        <div class="w-3/4 mx-auto sm:px-6 lg:px-8">

            @include('transaction.partials.single', ['transaction' => $transaction])

        </div>
    </div>
</x-guest-layout>
