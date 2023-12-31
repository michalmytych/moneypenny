<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Moneypenny\Home\Services\HomePageServiceInterface;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::prefix('transactions')->group(function () {

        Route::prefix('viewsets')->group(function () {
            Route::get('/home', function (Request $request) {
                return app(HomePageServiceInterface::class)->getHomeData(User::first());
            });
        });

    });

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::prefix('transactions')->as('transaction.')
            ->group(function () {
                Route::get('/', function (Request $request) {
                    return Transaction::query()
                        ->where('user_id', $request->user()->id)
                        ->latest()
                        ->paginate($request->get('perPage', 25));
                })->name('index');
            });

        require __DIR__ . '/api/user.php';
        require __DIR__ . '/api/analytics.php';
        require __DIR__ . '/api/profile.php';
        require __DIR__ . '/api/sync.php';
        require __DIR__ . '/api/notifications.php';
        require __DIR__ . '/api/reports.php';

        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/user', [UserController::class, 'user'])->name('user');

        Route::middleware('admin')->group(function () {
            require __DIR__ . '/api/admin.php';
        });
    });
});
