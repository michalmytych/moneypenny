<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Profile\ProfileController;

Route::prefix('profile')->as('profile.')->group(function() {
    Route::post('/', [ProfileController::class, 'selectLibraryAvatar'])->name('select_library_avatar');
});
