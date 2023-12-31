<?php

namespace App\Services\Auth\Device;

use App\Moneypenny\User\Models\User;
use App\Notification\Services\NotificationBroadcastService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use IvanoMatteo\LaravelDeviceTracking\Events\DeviceHijacked;

readonly class DeviceService
{
    public function __construct(private NotificationBroadcastService $notificationBroadcastService) {}

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
