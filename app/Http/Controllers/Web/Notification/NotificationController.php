<?php

namespace App\Http\Controllers\Web\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\Notification\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
