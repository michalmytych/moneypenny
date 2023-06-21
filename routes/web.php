<?php

use Illuminate\Support\Facades\Route;
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

    require __DIR__ . '/web/admin.php';
    require __DIR__ . '/web/transactions.php';
    require __DIR__ . '/web/analytics.php';
    require __DIR__ . '/web/budgets.php';
    require __DIR__ . '/web/files.php';
    require __DIR__ . '/web/imports.php';
    require __DIR__ . '/web/institutions.php';
    require __DIR__ . '/web/notifications.php';
    require __DIR__ . '/web/personal_accounts.php';
    require __DIR__ . '/web/personas.php';
    require __DIR__ . '/web/profile.php';
    require __DIR__ . '/web/reports.php';
    require __DIR__ . '/web/settings.php';
    require __DIR__ . '/web/social.php';
    require __DIR__ . '/web/synchronizations.php';
    require __DIR__ . '/web/versions.php';
    require __DIR__ . '/web/categories.php';
    require __DIR__ . '/web/file_explorer.php';

    Route::get('/', [EmptyUrlController::class, 'redirect'])->name('empty');
});

require __DIR__ . '/web/blocked.php';
require __DIR__ . '/web/auth.php';

