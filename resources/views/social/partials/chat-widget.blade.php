<div class="w-full rounded-md py-2 overflow-hidden">
    <div class="w-full rounded-md bg-white mb-6 shadow-sm px-4 flex-col overflow-y-scroll" style="height: 75vh;">
        @foreach($chatMessages as $chatMessage)
            <div
                class="flex items-start p-4 w-fit rounded-md mt-3 @if(request()->user()->name === $chatMessage['user']['name']) bg-indigo-50 ml-12 @else bg-gray-100 @endif shadow">
                <div class="mr-2" style="min-width: 50px;">
                    @include('components.profile.avatar', ['src' => $chatMessage['user']['avatar_path']])
                </div>
                <div>
                    <div class="font-semibold">
                        {{ $chatMessage['user']['name'] }}
                        <span
                            class="ml-2 text-sm text-gray-500">{{ \Carbon\Carbon::parse($chatMessage['timestamp'])->subMinutes(12)->diffForHumans() }}</span>
                    </div>
                    <div style="width: 800px; word-wrap: break-word;">
                        {{ $chatMessage['text'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div>
        <form action="{{ route('social.chat.send_message') }}" method="POST">
            @csrf
            <x-text-input
                id="chat_input"
                name="chat_input"
                type="text" class="mt-1 block w-full"
                autofocus
                placeholder="Write message"
            />
        </form>
    </div>
</div>
