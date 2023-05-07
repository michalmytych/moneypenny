<nav x-data="{ open: false }" class="bg-white">
    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        @include('icons.logo-md')
                    </a>
                </div>

                <!-- Navigation Links -->
                <div id="navLinks" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="flex h-full text-center content-center pt-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ __('Transakcje') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('transaction.index')">
                                    {{ __('Wszystkie') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('persona.index')">
                                    <span class="flex items-center justify-between">
                                        {{ __('Podmioty') }}
                                        <span class="relative top-2">
                                            @include('components.mainteance.beta-badge')
                                        </span>
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('import.index')">
                                    {{ __('Importy transakcji') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('file.index')">
                                    {{ __('Pliki') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('exchange_rate.index')">
                                    {{ __('Kursy walut') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="flex h-full text-center content-center pt-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ __('Konfiguracja') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('import.import-setting.index')">
                                    {{ __('Ustawienia importów') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('import.columns-mapping.index')">
                                    {{ __('Mapowanie kolumn') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="flex h-full text-center content-center pt-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ __('Integracje') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('institution.index')">
                                    {{ __('Integracje z instytucjami') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('synchronization.index')">
                                    {{ __('Synchronizacje') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="flex h-full text-center content-center pt-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ __('Aplikacja') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('debug.analyzers')">
                                    {{ __('Debugowanie analizatorów') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('meta.index')">
                                    {{ __('System') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="flex h-full text-center content-center pt-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ __('Raporty') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('report.periodic')">
                                    {{ __('Raport miesięczy') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="mr-4 font-bold">{{ Auth::user()->name }}</div>
                            <div>
                                @include('components.profile.avatar', ['src' => request()->user()?->getAvatarPath()])
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex justify-between">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div>
                    @include('components.profile.avatar', ['src' => request()->user()?->getAvatarPath()])
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<div id="secondNav" class="w-full mx-auto relative" style="display: none; z-index: 5;">
    <div class="w-full mt-px absolute bg-gradient-to-b from-indigo-200 h-72"></div>
    <div class="absolute w-full mt-4 pl-4 pr-4 sm:px-8">
        <div class="mx-20">
            @include('layouts.second-level-nav')
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const navLinks = document.querySelectorAll('.-nav-link');
        const secondNav = document.getElementById('secondNav');

        const showSecondNav = () => {
            secondNav.style.display = 'block';
        };

        const hideSecondNav = () => {
            secondNav.style.display = 'none';
        };

        window.addEventListener('load', () => {
            navLinks.forEach(navLink => {
                navLink.addEventListener('mouseover', () => {
                    showSecondNav();
                });
            });

            window.addEventListener('mousemove', function (event) {
                let mouseY = event.clientY;
                let windowHeight = window.innerHeight;
                let halfWindowHeight = windowHeight / 4;

                if (mouseY > halfWindowHeight) {
                    hideSecondNav();
                }
            });
        });
    </script>
@endpush
