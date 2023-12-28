<x-app-layout>
    <div class="w-full rounded-md mt-16 px-8">
        <div class="w-full flex items-center mb-4">
            <h1 class="text-3xl font-bold">
                {{ __('Local storage') }}
            </h1>
            <span class="ml-3 text-gray-400 pt-1">{{ storage_path() }}</span>
        </div>

        <div class="grid lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1">
            <div class="pb-48">
                @include('file_explorer.partials.folder', [
                    'url' => route('api.file_explorer.open', ['path' => storage_path()]),
                    'directoryName' => 'root',
                ])
            </div>

            <div id="fileDisplay"
                 class="sm:w-full ml-4 mt-2 lg:static md:fixed shadow-none lg:shadow-none md:shadow-2xl md:shadow-2xl sm:fixed bottom-20 left-2"></div>
        </div>

        @push('scripts')
            <script>
                window.addEventListener('load', () => {
                    const fileDisplay = document.getElementById('fileDisplay');
                    const directoryDetails = document.querySelectorAll('.directory-details');

                    directoryDetails.forEach(details => {
                        const getRenderedFile = (e) => {
                            try {
                                fetch(e.currentTarget.dataset.source, {
                                        headers: {
                                            'Accept-Type': 'application/json',
                                            'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                                            'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                                        }
                                    }
                                )
                                    .then(response => response.json())
                                    .then(json => {
                                        let render = '{{ __('Empty') }}';

                                        if (json.render) {
                                            render = json.render;
                                        }

                                        fileDisplay.innerHTML = render;
                                    });
                            } catch (e) {
                                //
                            }
                        }

                        const getRenderedDirectory = (e) => {
                            details = e.currentTarget;

                            if (!details.classList.contains('directory-details')) {
                                return;
                            }

                            const detailsWrapper = details.parentElement;

                            try {
                                fetch(details.dataset.source, {
                                        headers: {
                                            'Accept-Type': 'application/json',
                                            'X-XSRF-TOKEN': decodeURIComponent(getCookie('XSRF-TOKEN')),
                                            'Authorization': `Bearer ${window.localStorage.getItem('SANCTUM_API_TOKEN')}`
                                        }
                                    }
                                )
                                    .then(response => response.json())
                                    .then(json => {
                                        const wrapper = document.createElement('div');

                                        wrapper.style.paddingLeft = '1rem';

                                        detailsWrapper.querySelector('.loadingState').remove();
                                        detailsWrapper.removeChild(detailsWrapper.lastChild);
                                        detailsWrapper.appendChild(wrapper);

                                        wrapper.innerHTML += json.render;

                                        const childDirectoriesDetails = wrapper.querySelectorAll('.directory-details');
                                        const childFileDetails = wrapper.querySelectorAll('.file-details');

                                        childDirectoriesDetails.forEach(item => {
                                            item.addEventListener('click', getRenderedDirectory);
                                        });

                                        childFileDetails.forEach(item => {
                                            item.addEventListener('click', getRenderedFile);
                                        });

                                        details.classList.remove('directory-details');
                                    });
                            } catch (e) {
                                //
                            }
                        };

                        details.addEventListener('click', getRenderedDirectory);
                    });
                });
            </script>
        @endpush
    </div>
</x-app-layout>
