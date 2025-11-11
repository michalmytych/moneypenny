<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Synchronization\SynchronizationController;

Route::prefix('sync')->as('sync.')->group(function () {
    Route::post('/', [SynchronizationController::class, 'sync'])->name('synchronize');
});
