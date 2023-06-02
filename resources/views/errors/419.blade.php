<x-guest-layout>
    <div class="h-screen flex justify-center overflow-hidden">
        <div>
            <div class="flex justify-center w-full pb-1">
                <div>
                    <svg width="100" height="100" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="flex justify-center text-4xl font-semibold mt-2 mb-4">{{ __('419 Page expired') }}</h1>

            <p class="text-center text-xl mb-4">
                {{ __('You have been logged out for security reasons.') }}
            </p>

            <p class="text-center">
                <a class="text-indigo-600 font-semibold" href="{{ route('login') }}">Go to login page</a>.
            </p>
        </div>
    </div>
</x-guest-layout>
