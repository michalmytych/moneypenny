@if(count($files) > 0)
    <div class="text-black px-4 ml-2">
        <h1 class="text-3xl font-bold mb-4">Przesłane pliki</h1>
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
    <h2 class="font-semibold text-xl">Brak przesłanych plików</h2>
@endif


{{--<div class="text-black px-4 ml-2">--}}
{{--    <h1 class="text-3xl font-bold mb-4">Przesłane pliki</h1>--}}
{{--    <table class="min-w-full divide-y divide-gray-200">--}}
{{--        <thead class="bg-gray-50">--}}
{{--        <tr>--}}
{{--            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>--}}
{{--            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rozmiar</th>--}}
{{--            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dodano</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($files as $file)--}}
{{--            <tr>--}}
{{--                <td class="px-6 py-4 whitespace-nowrap text-sm text-black">--}}
{{--                    <a href="{{ route('file.show', ['id' => $file->id]) }}">--}}
{{--                        {{ $file->name }}--}}
{{--                    </a>--}}
{{--                </td>--}}
{{--                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
{{--                    @include('components.storage-size-display', ['size' => $file->size])--}}
{{--                </td>--}}
{{--                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
{{--                    {{ $file->created_at }}--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}
