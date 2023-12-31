<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Notification\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private readonly NotificationService $notificationService) {}

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $limit = $request->integer('limit', 5);
        $notifications = $this->notificationService->all($user, $limit);

        return response()->json([
            'notifications' => $notifications
        ]);
    }
}
