<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="lg:grid lg:grid-cols-[5fr_2fr] lg:gap-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex items-center justify-center">
                    <div>
                        <div id="avatar">
                            @include('components.profile.avatar', ['variant' => 'xl', 'src' => request()->user()?->getAvatarPath()])
                        </div>
                        <div id="editAvatarTrigger" class="flex-col justify-center">
                            <div id="avatarForm" class="flex-col mt-2 bg-gray-100 hidden rounded-lg p-2 shadow-md mb-4">
                                <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ \App\Models\File::USER_AVATAR }}">
                                    <input type="file" name="file" id="file" placeholder="Wybierz plik">
                                    <div class="text-center mt-5">
                                        <x-primary-button>{{ __('Upload') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>
                            <div class="flex mt-2 justify-center">
                                <span class="font-semibold ml-3">Change avatar</span>
                                <div class="relative left-1">
                                    @include('icons.edit')
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const avatar = document.getElementById('avatar');
            const editAvatarTrigger = document.getElementById('editAvatarTrigger');
            const avatarForm = document.getElementById('avatarForm');

            window.addEventListener('load', () => {
                editAvatarTrigger.addEventListener('click', () => {
                    avatar.style.display = 'none';

                    avatarForm.classList.remove('hidden');
                    avatarForm.style.width = '250px';
                    avatarForm.style.margin = '0 auto';
                    avatarForm.style.height = (avatar.offsetHeight + 100).toString() + 'px';
                    avatarForm.style.visibility = 'visible';
                });
            });
        </script>
    @endpush
</x-app-layout>
