<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\Api\FileExplorer\FileExplorerController;

Route::prefix('meta')->as('meta.')->group(function () {
    Route::get('processes', [MetaController::class, 'processes'])->name('processes');
    Route::get('jobs', [MetaController::class, 'jobs'])->name('jobs');
});

Route::prefix('file-explorer')->as('file_explorer.')->group(function () {
    // @todo ASAP - secure routes
    Route::get('/get', [FileExplorerController::class, 'get'])->name('get');
    Route::get('/show', [FileExplorerController::class, 'show'])->name('show');
    Route::get('/open', [FileExplorerController::class, 'open'])->name('open');
});

