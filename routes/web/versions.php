<?php

use App\Moneypenny\Version\Http\Controller\Web\VersionController;
use Illuminate\Support\Facades\Route;

Route::prefix('versions')->as('version.')->group(function () {
    Route::get('/', [VersionController::class, 'releaseNotes'])->name('release_notes');
});
