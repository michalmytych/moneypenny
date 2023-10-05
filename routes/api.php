<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['deny_blocked'])->as('api.')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        require __DIR__ . '/api/user.php';
        require __DIR__ . '/api/analytics.php';
        require __DIR__ . '/api/profile.php';
        require __DIR__ . '/api/sync.php';
        require __DIR__ . '/api/exchange_rates.php';
        require __DIR__ . '/api/notifications.php';
        require __DIR__ . '/api/reports.php';

        Route::middleware('admin')->group(function () {
            require __DIR__ . '/api/admin.php';
        });
    });
});
