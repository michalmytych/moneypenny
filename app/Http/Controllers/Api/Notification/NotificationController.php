<?php

namespace App\Http\Controllers\Api\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationService;

class NotificationController extends Controller
{
    public function __construct(private readonly NotificationService $notificationService) {}

    public function index(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 5);
        $notifications = $this->notificationService->all($limit);

        return response()->json([
            'notifications' => $notifications
        ]);
    }
}
