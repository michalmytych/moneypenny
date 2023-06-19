<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\FileExplorer\FileExplorerController;


Route::prefix('file-explorer')->as('file_explorer.')->group(function () {
    Route::get('/', [FileExplorerController::class, 'index'])
        ->middleware(['auth', 'admin'])
        ->name('index');

    // @todo ASAP - secure routes
    Route::get('/get', [FileExplorerController::class, 'get'])->name('get');
    Route::get('/show', [FileExplorerController::class, 'show'])->name('show');
    Route::get('/open', [FileExplorerController::class, 'open'])->name('open');
});
