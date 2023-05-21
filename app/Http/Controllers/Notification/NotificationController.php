<?php

namespace App\Http\Controllers\Notification;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Notification\NotificationService;

class NotificationController extends Controller
{
    public function __construct(private readonly NotificationService $notificationService) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $notifications = $this->notificationService->all($user);
        return view('notifications.index', compact('notifications'));
    }

    public function redirect(Notification $notification): RedirectResponse
    {
        $notification->update(['status' => Notification::STATUS_READ]);
        $url = json_decode($notification->content, true)['url'];
        return redirect($url);
    }
}
