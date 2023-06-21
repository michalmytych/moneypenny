<?php

use App\Http\Controllers\Api\MetaController;
use Illuminate\Support\Facades\Route;

Route::prefix('meta')->as('meta.')->group(function () {
    Route::get('processes', [MetaController::class, 'processes'])->name('processes');
    Route::get('jobs', [MetaController::class, 'jobs'])->name('jobs');
});
