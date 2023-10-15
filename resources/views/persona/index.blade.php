<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            <div>
                <h2 class="text-3xl font-semibold mb-4 flex">
                    {{ __('Personas') }} @include('components.maintenance.beta-badge')
                </h2>
            </div>

            @if(count($personas) > 0)
                <div class="overflow-x-scroll">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Alias') }}
                            </th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('As sender') }}
                            </th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('As receiver') }}
                            </th>
                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Related names') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($personas as $persona)
                            <tr
                                    id="row_{{$persona->id}}"
                                    class="@if(request()->get('selected_persona_id') === (string) $persona->id) bg-indigo-100 @endif"
                            >
                                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                    <form method="post"
                                          action="{{ route('persona.update', ['persona' => $persona->id]) }}">
                                        @csrf
                                        <input
                                                id="{{ $persona->id }}_value_input"
                                                type="text"
                                                name="common_name"
                                                class="border-none rounded-md"
                                                value="{{ $persona->common_name }}"
                                        >
                                        <input type="hidden" name="_method" value="PATCH">
                                        <input type="hidden" value="PATCH" id="">
                                        {{--<div class="relative bottom-11 -left-1.5 bg-indigo-600 rounded-full w-3 h-3" style="z-index: 5"></div>--}}
                                    </form>
                                    <a href="{{ route('persona.index', ['selected_persona_id' => $persona->id]) }}"
                                       class="border-indigo-100 pl-10">
                                        @include('icons.go')
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $persona->transactions_as_sender_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $persona->transactions_as_receiver_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex">
                                        @foreach(json_decode($persona->associated_names, true) as $name)
                                            <div class="rounded-md px-3 mx-1 bg-gray-200">{{ $name }}</div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @if(isset($selected_persona))
                            <div class="fixed top-0 left-0 w-full bg-white shadow-2xl"
                                 style="height: 250px; z-index: 10;">
                                <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-indigo-200"></div>
                                <div class="mx-auto w-5/6 h-4/5 mb-2 mt-6">
                                    <div>
                                        <h1 class="text-3xl font-semibold">{{ $selected_persona->common_name }}</h1>
                                        <ul class="mt-2 flex shadow-inner shadow-b shadow-white h-9 overflow-y-scroll">
                                            @foreach(json_decode($selected_persona->associated_names, true) as $name)
                                                <li class="mb-1">
                                                    <div
                                                            class="rounded-md px-3 mr-1 bg-gray-200 w-max">{{ $name }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </table>
                </div>
            @else
                <h2 class="font-semibold text-xl">
                    {{ __('No personas') }}
                </h2>
            @endif

            @if(isset($selected_persona))
                <a href="{{ route('persona.index') }}">
                    <div style="z-index: 12;"
                         class="fixed top-56 left-8 w-12 h-12 bg-indigo-600 text-white rounded-full font-semibold flex text-center justify-center pt-3 cursor-pointer transition transform-gpu ease-in-out active:scale-75 hover:scale-125">
                        <span class="relative w-6 h-6 rotate-90">
                            @include('icons.arrow-left')
                        </span>
                    </div>
                </a>
            @endif

        </div>
    </div>

</x-app-layout>
