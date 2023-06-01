<?php

namespace App\Services\Auth\Device;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use IvanoMatteo\LaravelDeviceTracking\Models\Device;
use IvanoMatteo\LaravelDeviceTracking\Events\DeviceHijacked;
use App\Services\Notification\Broadcast\NotificationBroadcastService;

class DeviceService
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService) {}

    public function all(User $user): Collection
    {
        $devices = $user->device()->get();

        if (!($devices instanceof SupportCollection)) {
            $devices = collect($devices);
        }

        return $devices;
    }

    public function handleWhenDeviceHijacked(DeviceHijacked $event): void
    {
        $this->notificationBroadcastService->sendStoredApplicationNotification(
            header: 'Warning! Suspicious activity detected.',
            content: 'Details: ' . $event->message,
            url: route('devices')
            // @todo send to specific users
        );
    }
}
