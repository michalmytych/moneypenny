@extends('file_explorer.base')

@section('content')
    <div class="bg-white w-full rounded-md">
        <div class="w-full flex items-center mb-4">
            <h1 class="text-3xl font-bold">
                {{ __('Local storage') }}
            </h1>
            <span class="ml-3 text-gray-400 pt-1">{{ storage_path() }}</span>
        </div>

        <div class="grid grid-cols-2">
            <div>
                @include('file_explorer.partials.folder', [
                    'url' => route('file_explorer.open', ['path' => storage_path()]),
                    'directoryName' => 'root',
                ])
            </div>

            <div id="fileDisplay" class="ml-4 mt-2"></div>
        </div>

        @push('scripts')
            <script>
                window.addEventListener('load', () => {
                    const fileDisplay = document.getElementById('fileDisplay');
                    const directoryDetails = document.querySelectorAll('.directory-details');

                    directoryDetails.forEach(details => {
                        const getRenderedFile = (e) => {
                            try {
                                fetch(e.currentTarget.dataset.source)
                                    .then(response => response.json())
                                    .then(json => {
                                        console.log(json);
                                        fileDisplay.innerHTML = json.render;
                                    });
                            } catch (e) {
                                //
                            }
                        }

                        const getRenderedDirectory = (e) => {
                            details = e.currentTarget;
                            console.log('clicked : [' + e.currentTarget.dataset.name + ']');
                            if (!details.classList.contains('directory-details')) {
                                return;
                            }
                            const detailsWrapper = details.parentElement;
                            console.log('getRenderedItem : [' + details.dataset.name + ']');
                            try {
                                fetch(details.dataset.source)
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
                            } catch(e) {
                                //
                            }
                        };

                        details.addEventListener('click', getRenderedDirectory);
                    });
                });
            </script>
        @endpush
    </div>
@endsection
