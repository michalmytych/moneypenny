@if (Session::has(config('session.flash_messages_key')))
    <div class="max-w-7xl mx-auto px-16 mt-8">
        @foreach (Session::get(config('session.flash_messages_key'), []) as $sessionMessage)
            <div class="flex rounded-md bg-indigo-600 text-white shadow-sm items-center p-2">
                @include('icons.info')
                <div class="ml-2">
                    {{ $sessionMessage }}
                </div>
            </div>
        @endforeach
    </div>
@endif

@if (Session::has(config('session.flash_errors_key')))
    <div class="max-w-7xl mx-auto px-16 mt-8">
        @foreach (Session::get(config('session.flash_errors_key'), []) as $sessionError)
            <div class="flex rounded-md bg-red-600 text-white shadow-sm items-center p-2">
                @include('icons.error')
                <div class="ml-2">
                    {{ $sessionError }}
                </div>
            </div>
        @endforeach
    </div>
@endif
