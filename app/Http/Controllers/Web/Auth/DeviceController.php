<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Device\DeviceService;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function __construct(private readonly DeviceService $deviceService) {}

    public function index(): View
    {
        $devices = $this->deviceService->all();
        return view('auth.devices', ['devices' => $devices]);
    }
}
