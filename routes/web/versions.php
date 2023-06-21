<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Version\VersionController;

Route::prefix('versions')->as('version.')->group(function () {
    Route::get('/', [VersionController::class, 'releaseNotes'])->name('release_notes');
});
