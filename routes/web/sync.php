<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Synchronization\SynchronizationController;

Route::prefix('sync')->as('sync.')->group(function () {
    Route::post('/', [SynchronizationController::class, 'sync'])->name('synchronize');
});
