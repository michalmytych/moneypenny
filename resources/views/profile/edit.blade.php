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
                        <div class="flex-col justify-center">
                            <div id="avatarForm" class="flex-col mt-2 bg-gray-100 hidden rounded-lg p-2 shadow-md mb-6 pb-2">
                                <form id="_avatarForm" action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ \App\Models\File::USER_AVATAR }}">

                                    <div class="mb-4">
                                        <x-file-drop fileInputName="file"/>
                                    </div>

                                    <div class="text-center mt-5">
                                        <x-primary-button id="uploadButton">{{ __('Upload') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>
                            <div class="flex mt-2 justify-center cursor-pointer hover:text-gray-500" id="selectAvatarFormTrigger">
                                <div class="relative" style="top: 1px;">
                                    @include('icons.image')
                                </div>
                                <div id="avatarsGallery" style="display: none;">
                                    @include('profile.partials.avatars-gallery', [
                                        'userUploadedAvatar' => request()->user()?->getAvatarPath()
                                    ])
                                </div>
                                <span class="ml-2 hover:underline">{{ __('Select avatar') }}</span>
                            </div>
                            <div class="flex mt-2 justify-center cursor-pointer hover:text-gray-500" id="changeAvatarFormTrigger">
                                <div class="relative" style="top: 1px;">
                                    @include('icons.edit')
                                </div>
                                <span class="ml-2 hover:underline">{{ __('Upload avatar') }}</span>
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
            const editAvatarTrigger = document.getElementById('changeAvatarFormTrigger');
            const avatarForm = document.getElementById('avatarForm');
            const changeAvatarFormTrigger = document.getElementById('changeAvatarFormTrigger');
            const avatarsGallery = document.getElementById('avatarsGallery');
            const selectAvatarFormTrigger = document.getElementById('selectAvatarFormTrigger');

            window.addEventListener('load', () => {
                editAvatarTrigger.addEventListener('click', () => {
                    avatar.style.display = 'none';
                    changeAvatarFormTrigger.style.display = 'none';

                    avatarForm.classList.remove('hidden');
                    avatarForm.style.width = '100%';
                    avatarForm.style.margin = '0 auto';
                    avatarForm.style.height = '100%';
                    avatarForm.style.visibility = 'visible';
                });

                const selectLibraryAvatar = (serverPath, tmpSrc) => {
                    fetch("{{ route('api.profile.select_library_avatar') }}", {
                            method: 'POST',
                            body: JSON.stringify({
                                server_path: serverPath,
                            }),
                            headers: {
                                "Content-Type": "application/json",
                                'Accept-Type': 'application/json',
                                'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                                'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                            },
                        }
                    )
                        .then(response => response.json())
                        .then(data => {
                           if (data.copied) {
                               const avatarImages = document.querySelectorAll('.avatarImage');
                               avatarImages.forEach(avatarImage => {
                                   avatarImage.setAttribute('src', tmpSrc);
                               });
                           }
                        });
                }

                const libraryAvatars = document.querySelectorAll('.libraryAvatar');
                libraryAvatars.forEach(libraryAvatar => {
                    const listener = () => {
                        selectLibraryAvatar(libraryAvatar.dataset.serverpath, libraryAvatar.src);
                    };
                    libraryAvatar.removeEventListener('click', listener)
                    libraryAvatar.addEventListener('click', listener);
                });

                selectAvatarFormTrigger.addEventListener('click', () => {
                    if (avatarsGallery.style.display === 'none') {
                        avatarsGallery.classList.remove('fade-in');
                        avatarsGallery.classList.add('fade-in');
                        avatarsGallery.style.display = '';
                    } else {
                        avatarsGallery.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const _avatarForm = document.getElementById('_avatarForm');
                const uploadButton = document.getElementById('uploadButton');
                const loaderWrapper = document.getElementById('loaderWrapper');
                _avatarForm.addEventListener('submit', () => {
                    alert('HELLLO');
                    uploadButton.disabled = 'true';
                    loaderWrapper.style.visibility = 'visible';
                });
            });
        </script>
    @endpush
</x-app-layout>
