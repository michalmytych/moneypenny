<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Notification\NotificationController;

Route::prefix('notifications')->as('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/redirect/{notification}', [NotificationController::class, 'redirect'])->name('redirect');
});
