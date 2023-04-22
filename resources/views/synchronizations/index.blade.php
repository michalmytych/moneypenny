<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('synchronizations.partials.synchronizations-list', ['synchronizations' => $synchronizations])

        </div>
    </div>
</x-app-layout>
