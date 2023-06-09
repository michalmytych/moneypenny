<?php

use App\Http\Controllers\Web\Social\ChatController;
use Illuminate\Support\Facades\Route;

Route::prefix('social')->as('social.')->group(function () {
    Route::prefix('chat')->as('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send_message');
    });
});
