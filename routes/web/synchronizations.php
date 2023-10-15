<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Synchronization\SynchronizationController;

Route::prefix('synchronizations')->as('synchronization.')->group(function () {
    Route::get('/', [SynchronizationController::class, 'index'])->name('index');
});
