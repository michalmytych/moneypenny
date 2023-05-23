@if(count($files) > 0)
    <div class="text-black px-4 ml-2">
        <h1 class="text-3xl font-bold mb-4">
            {{ __('Uploaded files') }}
        </h1>
        <div class="mt-2 rounded-md bg-white shadow-inner">

            @foreach($files as $file)
                <a href="{{ route('file.show', ['id' => $file->id]) }}">
                    <div class="flex items-center pb-1 transition hover:bg-gray-50">
                        <div class="text-gray-600 m-4">
                            @include('icons.file')
                        </div>
                        <div>
                            {{ $file->name }}
                        </div>
                        <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file->created_at->diffForHumans() }}
                        </div>
                        <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @include('components.storage-size-display', ['size' => $file->size])
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@else
    <h2 class="font-semibold text-xl">{{ __('No uploaded files') }}</h2>
@endif

