<?php

use App\Notification\Http\Controller\Web\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->as('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/redirect/{notification}', [NotificationController::class, 'redirect'])->name('redirect');
});
