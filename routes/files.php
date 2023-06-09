<?php

use App\Http\Controllers\Web\File\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix('files')->as('file.')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('index');
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    Route::get('{id}', [FileController::class, 'show'])->name('show');
});

