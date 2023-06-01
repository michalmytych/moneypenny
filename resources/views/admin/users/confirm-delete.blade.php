<x-app-layout>
    <div class="pt-8 pb-8 w-full mx-auto">
        <div class="w-2/3 lg:w-2/3 md:w-3/4 sm:w-full mx-auto px-4 lg:px-8 pb-20">

            <section class="space-y-6">
                <header>
                    <h2 class="text-2xl font-semibold text-gray-900 pb-2">
                        {{ __('Do you really want to delete user ') }} {{ $user->name }}?
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("This action cannot be undone.") }}
                    </p>
                </header>

                <div class="mt-6">
                    <form method="POST" action="{{ route('user.delete', ['id' => $user->id]) }}">
                        @csrf
                        @method('DELETE')

                        <div class="flex justify-end mt-6 items-center">
                            <a href="{{ route('user.index') }}" class="text-indigo-600 font-semibold mx-4">
                                {{ __('Cancel') }}
                            </a>

                            <x-danger-button class="ml-3">
                                {{ __('Delete') }}
                            </x-danger-button>
                        </div>
                    </form>
                </div>

        </div>
    </div>
</x-app-layout>
