<?php

namespace App\Events\Notification;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ApplicationNotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $header,
        public string $message,
        public string $url
    ) {
    }

    public function broadcastAs(): string
    {
        return 'application_notification_sent';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('application_notifications');
    }
}
