<x-app-layout>
    <section class="mt-12 mx-4">
        <h2 class="text-black font-bold text-3xl pb-4 pt-4">{{ __('Notifications console') }}</h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("From here, you can send application notifications to users.") }}
        </p>

        <form method="POST" action="{{ route('notification.send') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-input-label for="headerInput" :value="__('Header')"/>
                <x-text-input id="headerInput" name="header" type="text" class="mt-1 block w-full" required autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('header')"/>
            </div>

            <div>
                <x-input-label for="contentInput" :value="__('Content')"/>
                <x-text-input id="contentInput" name="content" type="text" class="mt-1 block w-full" required
                              autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('content')"/>
            </div>

            <div>
                <x-input-label for="urlInput" :value="__('Link')"/>
                <x-text-input id="urlInput" name="url" type="text" class="mt-1 block w-full" value="{{ route('home') }}" autofocus/>
                <x-input-error class="mt-2" :messages="$errors->get('url')"/>
            </div>

            <div>
                <x-input-label for="userIdInput"
                               :value="__('User (if empty, notifications will be sent to every user)')"/>
                <select
                    id="userIdInput"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 appearance-none rounded-md w-full py-2 mt-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="user_id">
                    <option value="{{ null }}" selected>{{ __('All users') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="typeInput"
                               :value="__('Notification type')"/>
                <select
                    id="typeInput"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md w-full mt-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="type">
                    <option value="{{ null }}" selected>{{ __('Default (Info)') }}</option>
                    @foreach($notificationsTypes as $notificationTypeName => $notificationTypeValue)
                        <option value="{{ $notificationTypeValue }}">
                            {{ $notificationTypeName }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2"/>
            </div>


            <div class="flex items-center justify-end gap-4">
                <x-secondary-button id="notifPreviewBtn">{{ __('Preview notification') }}</x-secondary-button>
                <x-primary-button>{{ __('Send') }}</x-primary-button>
            </div>
        </form>
    </section>

    @push('scripts')
        <script>
            window.addEventListener('load', function () {
                const notifPreviewBtn = document.getElementById('notifPreviewBtn');

                notifPreviewBtn.addEventListener('click', () => {
                    notifPreviewBtn.disabled = true;
                    window.setTimeout(() => {
                        notifPreviewBtn.disabled = false;
                    }, 6000);

                    const urlInput = document.getElementById('urlInput');
                    const headerInput = document.getElementById('headerInput');
                    const contentInput = document.getElementById('contentInput');

                    showNotification({
                        header: headerInput.value,
                        message: contentInput.value,
                        url: urlInput.value,
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>
