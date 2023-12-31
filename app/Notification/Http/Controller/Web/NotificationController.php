<?php

namespace App\Notification\Http\Controller\Web;

use App\Moneypenny\User\Models\User;
use App\Notification\Http\Requests\Web\SendRequest;
use App\Notification\Models\Notification;
use App\Notification\Services\NotificationBroadcastService;
use App\Notification\Services\NotificationService;
use App\Shared\Http\Controller\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly NotificationBroadcastService $notificationBroadcastService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $notifications = $this->notificationService->all($user);

        return view('notifications.index', compact('notifications'));
    }

    public function console(): View
    {
        $users = User::all();
        $notificationsTypes = [
            'Info' => Notification::TYPE_INFO,
            'Event' => Notification::TYPE_EVENT,
            'Error' => Notification::TYPE_ERROR,
            'Success' => Notification::TYPE_SUCCESS,
            'Warning' => Notification::TYPE_WARNING,
        ];

        return view('notifications.console', compact('users', 'notificationsTypes'));
    }

    public function send(SendRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this
            ->notificationBroadcastService
            ->sendStoredApplicationNotification(
                header: $data['header'],
                content: $data['content'],
                url: $data['url'],
                userId: $data['user_id'],
                type: $data['type'],
            );

        return to_route('notification.console');
    }

    public function redirect(Notification $notification): RedirectResponse
    {
        $notification->update(['status' => Notification::STATUS_READ]);
        $url = json_decode($notification->content, true)['url'];

        return redirect($url);
    }
}
