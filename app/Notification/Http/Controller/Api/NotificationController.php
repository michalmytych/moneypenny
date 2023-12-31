<?php

namespace App\Notification\Http\Controller\Api;

use App\Notification\Services\NotificationService;
use App\Shared\Http\Controller\Controller;
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
