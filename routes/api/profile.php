<?php

use App\Moneypenny\User\Http\Controller\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->as('profile.')->group(function() {
    Route::post('/', [ProfileController::class, 'selectLibraryAvatar'])->name('select_library_avatar');
});
