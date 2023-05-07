<?php

namespace App\Http\Controllers\Notification;

use App\Models\Notification;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = Notification::latest()->get();
        return view('notifications.index', compact('notifications'));
    }

    public function redirect(Notification $notification): RedirectResponse
    {
        $notification->update(['status' => Notification::STATUS_READ]);
        $url = json_decode($notification->content, true)['url'];
        return redirect($url);
    }
}
