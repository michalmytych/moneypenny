<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ChatController extends Controller
{
    private const CHAT_MESSAGES_CACHE_KEY = 'chat_messages';

    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService) {}

    public function index(): View
    {
        $chatMessages = collect();

        if (Cache::missing(self::CHAT_MESSAGES_CACHE_KEY)) {
            Cache::put(self::CHAT_MESSAGES_CACHE_KEY, $chatMessages);
        } else {
            $chatMessages = Cache::get(self::CHAT_MESSAGES_CACHE_KEY);
        }

        return view('social.chat.index', compact('chatMessages'));
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $chatMessage = $request->input('chat_input');
        $user = $request->user();

        $this->notificationBroadcastService->sendStoredApplicationNotification(
            header: 'New chat message from ' . $user->name,
            content: $chatMessage,
            url: route('home', ['chat_opened' => true])
        );

        $chatMessages = Cache::get(self::CHAT_MESSAGES_CACHE_KEY);
        $chatMessages[] = [
            'text' => $chatMessage,
            'timestamp' => time(),
            'user' => [
                'name' => $user->name,
                'avatar_path' => $user->getAvatarPath()
            ]
        ];
        Cache::put(self::CHAT_MESSAGES_CACHE_KEY, $chatMessages);

        return redirect()->back();
    }
}
