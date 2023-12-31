<?php

use App\Moneypenny\User\Http\Controller\Web\BlockedUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('blocked')->as('blocked.')->group(function () {
    Route::get('/', [BlockedUserController::class, 'index'])
        ->name('index');
});
