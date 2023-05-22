<?php

namespace App\Console\Commands\Notification;

use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Console\Command;

class SendApplicationNotification extends Command
{
    protected $signature = 'moneypenny:send-app-notification {header} {content?} {url?} {userId?}';

    protected $description = 'Send application notifification via notification broadcasting service.';

    public function handle(NotificationBroadcastService $notificationBroadcastService): void
    {
        $header = $this->argument('header');
        $content = $this->argument('content') ?? 'No content';
        $url = $this->argument('url') ?? route('home');
        $userId = $this->argument('userId');

        $notificationBroadcastService->sendStoredApplicationNotification(
            header: $header,
            content: $content ,
            url: $url,
            userId: $userId,
        );
    }
}
