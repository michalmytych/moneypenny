<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Device\DeviceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function __construct(private readonly DeviceService $deviceService) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $devices = $this->deviceService->all($user);
        return view('auth.devices', ['devices' => $devices]);
    }
}
