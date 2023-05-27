<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div class="w-full mb-6 text-center flex justify-center">
        @include('icons.logo-lg')
    </div>

    <h1 class="flex justify-center text-3xl font-semibold mt-2">Sign in</h1>
    <form method="POST" action="{{ route('login') }}" class="sm:w-full lg:w-1/3 mb-8 mt-4 mx-auto" id="loginForm">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <div class="items-center">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('register') }}">Register</a>
                    <span class="text-xl font-semibold mx-2 relative top-0.5">•</span>
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif

            <x-primary-button class="ml-3" id="loginBtn">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
        <script>
            const apiLoginRoute = "{{ route('api.login') }}";
            const sancutmCSRFCookieRoute = "{{ route('sanctum.csrf-cookie') }}";

            window.addEventListener('load', () => {
                const loginForm = document.getElementById('loginForm');
                const loginBtn = document.getElementById('loginBtn');
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');

                const fetchSanctumCSRFToken = () => {
                    if (loginBtn.disabled) return false;

                    try {
                        return fetch(sancutmCSRFCookieRoute, {
                                method: "GET",
                                headers: {
                                    'Accept-Type': 'application/json',
                                }
                            }
                        );
                    } catch (e) {
                        console.error(e);
                    }
                }

                const loginApi = async () => {
                    if (loginBtn.disabled) return false;

                    return fetch(apiLoginRoute, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                'Accept-Type': 'application/json',
                                'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                            },
                            body: JSON.stringify({
                                password: passwordInput.value,
                                email: emailInput.value,
                            })
                        }
                    )
                        .then(response => response.json())
                        .then(json => {
                            window.localStorage.setItem('SANCTUM_API_TOKEN', json.token);
                        });
                }

                loginBtn.addEventListener('click', async (e) => {
                    e.preventDefault();

                    await fetchSanctumCSRFToken();
                    await loginApi();

                    loginForm.submit();
                });
            });
        </script>
    @endpush
</x-guest-layout>
