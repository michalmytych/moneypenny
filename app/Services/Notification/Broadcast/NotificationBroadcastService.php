<?php

namespace App\Services\Notification\Broadcast;

use App\Events\ApplicationNotificationSent;
use App\Models\Notification;

class NotificationBroadcastService
{
    public function sendStoredApplicationNotification(string $header, string $content, string $url): void
    {
        Notification::create([
            'content' => json_encode([
                'header' => $header,
                'content' => $content,
                'url' => $url,
            ]),
            'type'
        ]);

        broadcast(new ApplicationNotificationSent($header, $content, $url));
    }
}
