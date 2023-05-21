<?php

namespace App\Services\Auth\Device;

use Illuminate\Database\Eloquent\Collection;
use IvanoMatteo\LaravelDeviceTracking\Models\Device;
use IvanoMatteo\LaravelDeviceTracking\Events\DeviceHijacked;
use App\Services\Notification\Broadcast\NotificationBroadcastService;

class DeviceService
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService) {}

    public function all(): Collection
    {
        return Device::latest()->get();
    }

    public function handleWhenDeviceHijacked(DeviceHijacked $event): void
    {
        $this->notificationBroadcastService->sendStoredApplicationNotification(
            header: 'Warning! Suspicious activity detected.',
            content: 'Details: ' . $event->message,
            url: route('devices')
        );
    }
}
