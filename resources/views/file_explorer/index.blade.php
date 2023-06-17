@extends('file_explorer.base')

@section('content')
    <div class="bg-white w-full rounded-md">
        <div class="w-full flex items-center mb-4">
            <h1 class="text-3xl font-bold">
                {{ __('Local storage') }}
            </h1>
            <span class="ml-3 text-gray-400 pt-1">{{ storage_path() }}</span>
        </div>
{{--        <div class="w-full">--}}
{{--            <details class="mb-2 directory-details"--}}

{{--                     data-source="{{ route('file_explorer.open') }}">--}}
{{--                <summary class="transition bg-gray-100 shadow-sm hover:bg-gray-200 rounded-md cursor-pointer"--}}
{{--                         style="min-width: 250px; max-width: 450px;">--}}
{{--                    <div class="p-2 pl-3 font-semibold text-gray-700 flex items-center">--}}
{{--                        <div class="text-gray-400">--}}
{{--                            @include('icons.sm.folder')--}}
{{--                        </div>--}}
{{--                        <span class="ml-2">root</span>--}}
{{--                    </div>--}}
{{--                </summary>--}}
{{--            </details>--}}
{{--        </div>--}}

        <div class="w-1/3">
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
                        const getRenderedItem = () => {
                            console.log('getRenderedItem');
                            fetch(details.dataset.source)
                                .then(response => response.json())
                                .then(json => {
                                    const wrapper = document.createElement('div');
                                    wrapper.style.paddingLeft = '1rem';
                                    // wrapper.style.backgroundColor = 'rgb(66, 135, 245, 0.2)';
                                    const detailsWrapper = details.parentElement;
                                    detailsWrapper.querySelector('.loadingState').remove();
                                    detailsWrapper.removeChild(detailsWrapper.lastChild);
                                    detailsWrapper.appendChild(wrapper);
                                    wrapper.innerHTML += json.render;
                                });
                        };

                        details.addEventListener('click', getRenderedItem);
                    });
                });
            </script>
        @endpush
    </div>
@endsection
