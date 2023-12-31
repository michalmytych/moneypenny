<?php

use App\Moneypenny\Synchronization\Http\Controller\Api\SynchronizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('sync')->as('sync.')->group(function () {
    Route::post('/', [SynchronizationController::class, 'sync'])->name('synchronize');
});
