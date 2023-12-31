<?php

use App\Moneypenny\Synchronization\Http\Controller\Web\SynchronizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('synchronizations')->as('synchronization.')->group(function () {
    Route::get('/', [SynchronizationController::class, 'index'])->name('index');
});
