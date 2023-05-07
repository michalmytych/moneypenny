@if(count($notifications) > 0)
    <h2 class="text-black font-bold text-2xl pb-4">Powiadomienia</h2>
    <div>
        @foreach($notifications as $notification)
            @php
                $notifiactionData = json_decode($notification->content, true);
            @endphp
            <a href="{{ route('notification.redirect', ['notification' => $notification->id]) }}">
            <div class="bg-white rounded-md shadow-sm p-4 mb-4 transition scale-hover">
                <div class="flex justify-between items-center">
                    <h4 class="text-2xl font-semibold flex">
                        @if($notification->status === \App\Models\Notification::STATUS_UNREAD)
                            <div class="bg-indigo-600 rounded-full self-center mr-3" style="width: 10px; height: 10px;"></div>
                        @else
                            <div class="bg-gray-400 rounded-full self-center mr-3" style="width: 10px; height: 10px;"></div>
                        @endif
                        {{ $notifiactionData['header'] }}
                    </h4>
                </div>
                <div class="font-light text-gray-500 my-2">{{ $notification->created_at }}</div>
                <p>
                    {{ $notifiactionData['content'] }}
                </p>
            </div>
            </a>
        @endforeach
    </div>
@else
    <h2 class="font-semibold text-xl">Brak powiadomień</h2>
@endif

