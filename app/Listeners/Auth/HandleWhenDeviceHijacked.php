<?php

namespace App\Listeners\Auth;

use App\Services\Auth\Device\DeviceService;
use IvanoMatteo\LaravelDeviceTracking\Events\DeviceHijacked;

readonly class HandleWhenDeviceHijacked
{
    public function __construct(private DeviceService $deviceService)
    {
    }

    public function handle(object $event): void
    {
        /**
 * @var DeviceHijacked $event 
*/
        $this->deviceService->handleWhenDeviceHijacked($event);
    }
}
