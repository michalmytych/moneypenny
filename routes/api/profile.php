<?php

use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->as('profile.')->group(function() {
    Route::post('/', [ProfileController::class, 'selectLibraryAvatar'])->name('select_library_avatar');
});
