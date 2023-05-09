<?php

namespace App\Services\Notification;

use App\Models\Notification;
use Illuminate\Support\Collection;

class NotificationService
{
    public function all(int $limit = 5): Collection
    {
        return Notification::latest()->limit($limit)->get();
    }
}
