<?php

namespace App\Http\Controllers\Api\Notification;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 5);
        $notifications = Notification::latest()->limit($limit)->get();

        return response()->json([
            'notifications' => $notifications
        ]);
    }
}
