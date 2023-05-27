<?php

namespace App\Services\Notification\Broadcast;

use App\Models\Notification;
use App\Events\Notification\ApplicationNotificationSent;

class NotificationBroadcastService
{
    public function sendStoredApplicationNotification(string $header, string $content, string $url, mixed $userId = null): void
    {
        Notification::create([
            'user_id' => $userId,
            'content' => json_encode([
                'header' => $header,
                'content' => $content,
                'url' => $url,
            ]),
            'type' => Notification::TYPE_INFO // @todo resolve notification type
        ]);

        // @todo - broadcast only to specific users
        broadcast(new ApplicationNotificationSent($header, $content, $url));
    }
}
