<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\ProfileController;

Route::prefix('profile')->as('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});
