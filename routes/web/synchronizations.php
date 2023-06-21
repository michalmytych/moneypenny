<?php

use App\Http\Controllers\Web\Synchronization\SynchronizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('synchronizations')->as('synchronization.')->group(function () {
    Route::get('/', [SynchronizationController::class, 'index'])->name('index');
});
