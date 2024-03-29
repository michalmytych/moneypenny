<?php

namespace App\Services\Notification;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Collection;

class NotificationService
{
    public function all(User $user, int $limit = 5): Collection
    {
        return Notification::whereUser($user)->latest()->limit($limit)->get();
    }

    public function allEvents(User $user, int $limit = 5)
    {
        return Notification::whereUser($user)
            ->where('type', Notification::TYPE_EVENT)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
