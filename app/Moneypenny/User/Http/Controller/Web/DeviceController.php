<?php

namespace App\Moneypenny\User\Http\Controller\Web;

use App\Services\Auth\Device\DeviceService;
use App\Shared\Http\Controller\Controller;
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
