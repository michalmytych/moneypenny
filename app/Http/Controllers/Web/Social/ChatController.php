<?php

namespace App\Http\Controllers\Web\Social;

use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Http\Controllers\Controller;
use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    private const CHAT_MESSAGES_CACHE_KEY = 'chat_messages';

    public function __construct(
        private readonly CacheAdapterInterface $cacheAdapter,
        private readonly NotificationBroadcastService $notificationBroadcastService
    ) {}

    public function index(): View
    {
        $chatMessages = [];

        if ($this->cacheAdapter->missing(self::CHAT_MESSAGES_CACHE_KEY)) {
            $this->cacheAdapter->put(self::CHAT_MESSAGES_CACHE_KEY, $chatMessages);
        } else {
            $chatMessages = $this->cacheAdapter->get(self::CHAT_MESSAGES_CACHE_KEY, []);
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

        $chatMessages = $this->cacheAdapter->get(self::CHAT_MESSAGES_CACHE_KEY, []);
        $chatMessages[] = [
            'text' => $chatMessage,
            'timestamp' => time(),
            'user' => [
                'name' => $user->name,
                'avatar_path' => $user->getAvatarPath()
            ]
        ];

        $this->cacheAdapter->put(self::CHAT_MESSAGES_CACHE_KEY, $chatMessages);

        return redirect()->back();
    }
}
