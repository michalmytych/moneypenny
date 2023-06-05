<nav x-data="{ open: false }" class="bg-white fixed top-0 w-full shadow-sm z-50">
    <!-- Primary Navigation Menu -->
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        @include('icons.logo-md')
                    </a>
                    <div class="relative top-1.5 ml-9">
                        @if(Auth::user()->isAdmin())
                            @include('admin.partials.admin-badge')
                        @endif
                    </div>
                </div>

                <!-- Navigation Links -->
                <div id="navLinks" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="flex h-full text-center content-center pt-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{ __('Transactions') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('transaction.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.list')
                                    </div>
                                    {{ __('All transactions') }}
                                </x-dropdown-link>
                                @if(config('personas.enabled'))
                                    <x-dropdown-link :href="route('persona.index')">
                                    <span class="flex items-center justify-between">
                                        {{ __('Personas') }}
                                        <span class="relative top-2">
                                            @include('components.mainteance.beta-badge')
                                        </span>
                                    </span>
                                    </x-dropdown-link>
                                @endif
                                <x-dropdown-link :href="route('analytic.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.chart')
                                    </div>
                                    {{ __('Analytics') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('import.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.import')
                                    </div>
                                    {{ __('Imports') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('file.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.files')
                                    </div>
                                    {{ __('Files') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('setting.edit')">
                                    <div class="mr-2">
                                        @include('icons.sm.settings')
                                    </div>
                                    {{ __('Settings') }}
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
                                        {{ __('Reports') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('report.periodic')">
                                    <div class="mr-2">
                                        @include('icons.sm.report')
                                    </div>
                                    {{ __('Month report') }}
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
                                        {{ __('Budgets') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('budget.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.budget')
                                    </div>
                                    {{ __('All budgets') }}
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
                                        {{ __('Integrations') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('institution.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.bank')
                                    </div>
                                    {{ __('Banks integrations') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('synchronization.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.sync')
                                    </div>
                                    {{ __('Synchronizations') }}
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
                                        {{ __('Configuration') }}
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('import.import-setting.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.config')
                                    </div>
                                    {{ __('Import settings') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('import.columns-mapping.index')">
                                    <div class="mr-2">
                                        @include('icons.sm.columns')
                                    </div>
                                    {{ __('Columns mappings') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    @if(request()->user()?->is_admin)
                        <div class="flex h-full text-center content-center pt-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>
                                            {{ __('Mainteance') }}
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    @if(config('debugging.enabled'))
                                        <x-dropdown-link :href="route('debug.analyzers')">
                                            {{ __('Debugging') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('exchange_rate.index')">
                                            {{ __('Exchange rates') }}
                                        </x-dropdown-link>
                                    @endif
                                    <x-dropdown-link :href="route('user.index')">
                                        <div class="mr-2">
                                            @include('icons.sm.users')
                                        </div>
                                        {{ __('Users') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('meta.index')">
                                        <div class="mr-2">
                                            @include('icons.sm.system')
                                        </div>
                                        {{ __('System') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    @if(config('network.enabled'))
                        <div class="flex h-full text-center content-center pt-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>
                                            {{ __('Network') }}
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('social.chat.index')">
                                    <span class="flex items-center justify-between">
                                        {{ __('Chat') }}
                                        <span class="relative top-2">
                                            @include('components.mainteance.beta-badge')
                                        </span>
                                    </span>
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                @include('layouts.partials.chat-icon')

                @include('layouts.partials.notifications-dropdown', ['prefix' => 'desktop'])

                <x-dropdown align="right" width="96">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @include('components.profile.avatar', ['src' => request()->user()?->getAvatarPath()])
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="w-full">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        @include('components.profile.avatar', ['src' => request()->user()?->getAvatarPath()])
                                    </div>
                                    <div>
                                        <div class="font-bold text-lg">
                                            {{ request()->user()?->name  }}
                                        </div>
                                        <div class="text-gray-600">
                                            {{ request()->user()?->email  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="mr-2">
                                @include('icons.sm.profile')
                            </div>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('devices')">
                            <div class="mr-2">
                                @include('icons.sm.device')
                            </div>
                            {{ __('Devices') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                logoutApi();
                                                this.closest('form').submit();">
                                <span class="text-red-700 font-semibold flex">
                                    <div class="mr-2">
                                    @include('icons.sm.logout')
                                </div>
                                    {{ __('Log Out') }}
                                </span>
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
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex justify-between">
                <div>
                    {{--@todo - should it be used as facade?--}}
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="flex items-center">
{{--                    @include('layouts.partials.notifications-dropdown', ['prefix' => 'mobile'])--}}
                    @include('components.profile.avatar', ['src' => request()->user()?->getAvatarPath()])
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('transaction.index')">
                    {{ __('All transactions') }}
                </x-responsive-nav-link>

                @if(config('personas.enabled'))
                    <x-responsive-nav-link :href="route('persona.index')">
                                    <span class="flex items-center justify-between">
                                        {{ __('Personas') }}
                                        <span class="relative top-2">
                                            @include('components.mainteance.beta-badge')
                                        </span>
                                    </span>
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('analytic.index')">
                    {{ __('Analytics') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('import.index')">
                    {{ __('Imports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('file.index')">
                    {{ __('Files') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('setting.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('report.periodic')">
                    {{ __('Month report') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('budget.index')">
                    {{ __('All budgets') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('institution.index')">
                    {{ __('Banks integrations') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('synchronization.index')">
                    {{ __('Synchronizations') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('import.import-setting.index')">
                    {{ __('Import settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('import.columns-mapping.index')">
                    {{ __('Columns mappings') }}
                </x-responsive-nav-link>
                @if(request()->user()?->is_admin)
                    @if(config('debugging.enabled'))
                        <x-responsive-nav-link :href="route('debug.analyzers')">
                            {{ __('Debugging') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('exchange_rate.index')">
                            {{ __('Exchange rates') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('meta.index')">
                        {{ __('System') }}
                    </x-responsive-nav-link>
                @endif
                @if(config('network.enabled'))
                    <x-responsive-nav-link :href="route('social.chat.index')">
                                    <span class="flex items-center justify-between">
                                        {{ __('Chat') }}
                                        <span class="relative top-2">
                                            @include('components.mainteance.beta-badge')
                                        </span>
                                    </span>
                    </x-responsive-nav-link>
                @endif
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); logoutApi(); this.closest('form').submit();">
                                        <span class="text-red-700 font-semibold">
                                            {{ __('Log Out') }}
                                        </span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

