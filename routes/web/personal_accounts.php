<?php

use App\Moneypenny\PersonalAccount\Http\Controller\Web\PersonalAccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('personal-accounts')->as('personal-account.')->group(function () {
    Route::get('/', [PersonalAccountController::class, 'index'])->name('index');
    Route::get('/edit', [PersonalAccountController::class, 'edit'])->name('edit');
    Route::put('/update', [PersonalAccountController::class, 'update'])->name('update');
});
