<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Transaction\SettingsController;

Route::prefix('settings')->as('setting.')->group(function () {
    Route::get('/', [SettingsController::class, 'edit'])->name('edit');
    Route::post('/', [SettingsController::class, 'update'])->name('update');
});
