@php
    $flashMessagesKey = config('session.flash_messages_key');
    $flashErrorsKey = config('session.flash_errors_key');
@endphp

<div class="max-w-7xl mx-auto">
    @if (Session::has($flashMessagesKey))
        <div class="mx-8 mt-10 shadow-xl">
            @foreach (Session::get($flashMessagesKey, []) as $sessionMessage)
                <div class="flex rounded-md bg-indigo-600 text-white shadow-sm items-center p-2">
                    @include('icons.info')
                    <div class="ml-2">
                        {{ $sessionMessage }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if (Session::has($flashErrorsKey))
        <div class="mx-8 mt-10 shadow-xl">
            @foreach (Session::get($flashErrorsKey, [__('Something went wrong.')]) as $sessionError)
                <div class="flex rounded-md bg-red-600 text-white shadow-sm items-center p-2">
                    @include('icons.error')
                    <div class="ml-2">
                        {{ $sessionError }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

