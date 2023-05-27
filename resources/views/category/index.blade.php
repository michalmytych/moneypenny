<x-app-layout>
    <div class="py-8 mx-auto">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            @include('category.partials.categories-list', ['categories' => $categories ])

        </div>
    </div>
</x-app-layout>
