<?php

use App\Moneypenny\User\Http\Controller\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->as('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});
