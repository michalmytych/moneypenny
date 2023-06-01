<x-app-layout>
    <div class="pt-8 pb-8 w-full mx-auto">
        <div class="w-2/3 lg:w-2/3 md:w-3/4 sm:w-full mx-auto px-4 lg:px-8 pb-20">

            <section class="space-y-6">
                <header>
                    <h2 class="text-2xl font-semibold text-gray-900 pb-2">
                        {{ __('Changing role for user') }} {{ $user->name }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Select role to which user will be assigned.") }}
                    </p>
                </header>

                <div class="mt-6">
                    <form method="POST" action="{{ route('user.change_role', ['id' => $user->id]) }}">
                        @csrf

                        <select name="role" id="type"
                                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @if($user->isAdmin())
                                <option selected value="ADMIN">Role: admin</option>
                                <option value="REGULAR_USER">Role: regular user</option>
                            @else
                                <option value="ADMIN">Role: admin</option>
                                <option selected value="REGULAR_USER">Role: regular user</option>
                            @endif
                        </select>

                        <div class="flex justify-end mt-6 items-center">
                            <a href="{{ route('user.index') }}" class="text-indigo-600 font-semibold mx-4">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button class="ml-3">
                                {{ __('Change') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

        </div>
    </div>
</x-app-layout>
