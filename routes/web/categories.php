<?php

use App\Moneypenny\Category\Http\Controller\Web\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->as('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
});
