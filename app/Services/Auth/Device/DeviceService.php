<?php

namespace App\Services\Auth\Device;

use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Database\Eloquent\Collection;
use IvanoMatteo\LaravelDeviceTracking\Events\DeviceHijacked;
use IvanoMatteo\LaravelDeviceTracking\Models\Device;

class DeviceService
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService) {}

    public function all(): Collection
    {
        return Device::all();
    }

    public function handleWhenDeviceHijacked(DeviceHijacked $event): void
    {
        $this->notificationBroadcastService->sendStoredApplicationNotification(
            header: 'Uwaga! Wykryto podejrzaną aktywność.',
            content: 'Informacje: ' . $event->message,
            url: route('devices')
        );
    }
}
