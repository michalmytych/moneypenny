<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlockedUserController;
use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Auth\SetupController;
use App\Http\Controllers\Web\Utils\EmptyUrlController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'deny_blocked'])->group(function () {
    Route::get('/setup', [SetupController::class, 'setup'])->name('setup');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    require __DIR__ . '/admin.php';
    require __DIR__ . '/analytics.php';
    require __DIR__ . '/budgets.php';
    require __DIR__ . '/files.php';
    require __DIR__ . '/imports.php';
    require __DIR__ . '/institutions.php';
    require __DIR__ . '/notifications.php';
    require __DIR__ . '/personal_accounts.php';
    require __DIR__ . '/personas.php';
    require __DIR__ . '/profile.php';
    require __DIR__ . '/reports.php';
    require __DIR__ . '/settings.php';
    require __DIR__ . '/social.php';
    require __DIR__ . '/synchronizations.php';
    require __DIR__ . '/transactions.php';
    require __DIR__ . '/versions.php';
    require __DIR__ . '/categories.php';
    require __DIR__ . '/file_explorer.php';

    Route::get('/', [EmptyUrlController::class, 'redirect'])->name('empty');
});

Route::prefix('blocked')->as('blocked.')->group(function () {
    Route::get('/', [BlockedUserController::class, 'index'])
        ->name('index');
});

require __DIR__ . '/auth.php';

