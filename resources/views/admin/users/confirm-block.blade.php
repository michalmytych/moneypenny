<x-app-layout>
    <div class="pt-8 pb-8 w-full mx-auto">
        <div class="w-2/3 lg:w-2/3 md:w-3/4 sm:w-full mx-auto px-4 lg:px-8 pb-20">

            <section class="space-y-6">
                <header>
                    <h2 class="text-2xl font-semibold text-gray-900 pb-2">
                        {{ __('Are you shure you want to block this user?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('User') }} <span class="font-semibold">{{ $user->name }}</span> {{ __("won't be able to login, or perform any action in the system.") }}
                    </p>
                </header>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <form method="POST" action="{{ route('user.block', ['id' => $user->id]) }}">
                        @csrf
                        <x-danger-button class="ml-3">
                            {{ __('Block user') }}
                        </x-danger-button>
                    </form>
                </div>

        </div>
    </div>
</x-app-layout>
