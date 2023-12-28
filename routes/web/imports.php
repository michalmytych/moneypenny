<?php

use App\Http\Controllers\Web\Import\ColumnsMappingController;
use App\Http\Controllers\Web\Import\ImportController;
use App\Http\Controllers\Web\Import\ImportSettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('imports')->as('import.')->group(function () {
    Route::get('/', [ImportController::class, 'index'])->name('index');

    Route::prefix('settings')->as('import-setting.')->group(function () {
        Route::get('/', [ImportSettingController::class, 'index'])->name('index');
        Route::get('/{id}', [ImportSettingController::class, 'show'])->name('show');
        Route::post('/', [ImportSettingController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [ImportSettingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ImportSettingController::class, 'update'])->name('update');
    });

    Route::prefix('columns-mappings')->as('columns-mapping.')->group(function () {
        Route::get('/', [ColumnsMappingController::class, 'index'])->name('index');
        Route::post('/', [ColumnsMappingController::class, 'create'])->name('create');
    });
});
