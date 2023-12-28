<?php

use App\Http\Controllers\Web\Transaction\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->as('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
});
