<?php

use App\Notification\Http\Controller\Api\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->as('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
});
