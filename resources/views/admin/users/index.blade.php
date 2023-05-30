<x-app-layout>
    <div class="pt-6 pb-8 w-full mx-auto">
        <div class="w-full mx-auto px-4 lg:px-8 pb-20">

            @include('admin.partials.users-list', ['users' => $users ])

        </div>
    </div>
</x-app-layout>
