<?php

use App\Moneypenny\User\Http\Controller\Web\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->as('setting.')->group(function () {
    Route::get('/', [SettingsController::class, 'edit'])->name('edit');
    Route::post('/', [SettingsController::class, 'update'])->name('update');
});
