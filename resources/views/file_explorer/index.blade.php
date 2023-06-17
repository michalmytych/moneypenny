@extends('file_explorer.base')

@section('content')
    <div class="bg-white w-full rounded-md">
        <div class="w-full flex items-center mb-4">
            <h1 class="text-3xl font-bold">
                {{ __('Local storage') }}
            </h1>
            <span class="ml-3 text-gray-400 pt-1">{{ storage_path() }}</span>
        </div>

        <div class="w-2/3 sm:w-4/5">
            @include('file_explorer.partials.folder', [
                'url' => route('file_explorer.open', ['path' => storage_path()]),
                'directoryName' => 'root',
            ])
        </div>

        @push('scripts')
            <script>
                window.addEventListener('load', () => {
                    const directoryDetails = document.querySelectorAll('.directory-details');
                    directoryDetails.forEach(details => {

                        const getRenderedItem = (e) => {
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
                                        const childDetails = wrapper.querySelectorAll('.directory-details');
                                        childDetails.forEach(item => {
                                            item.addEventListener('click', getRenderedItem);
                                        });
                                        details.classList.remove('directory-details');
                                    });
                            } catch(e) {
                                //
                            }
                        };

                        details.addEventListener('click', getRenderedItem);
                    });
                });
            </script>
        @endpush
    </div>
@endsection
