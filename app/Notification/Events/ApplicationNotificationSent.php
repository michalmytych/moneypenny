<?php

namespace App\Notification\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationNotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $header,
        public string $message,
        public string $url
    )
    {
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
