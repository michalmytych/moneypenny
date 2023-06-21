<?php

use App\Http\Controllers\Web\Synchronization\SynchronizationController; // @todo - move to web
use Illuminate\Support\Facades\Route;

Route::prefix('sync')->as('sync.')->group(function () {
    Route::post('/', [SynchronizationController::class, 'sync'])->name('synchronize');
});
