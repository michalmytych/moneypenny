<?php

use App\Http\Controllers\Api\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->as('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
});
