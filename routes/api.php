<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Transaction\Analytics\AnalyticsController;
use App\Http\Controllers\Api\Transaction\ReportController;
use App\Http\Controllers\Web\ExchangeRates\ExchangeRateController;
use App\Http\Controllers\Web\Synchronization\SynchronizationController;
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

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/user', [UserController::class, 'user'])->name('user');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// @todo - rm all related code
//        Route::prefix('analysis')->as('analysis.')->group(function () {
//            Route::post('/', [AnalysisController::class, 'analyze'])->name('analyze');
//        });

        Route::prefix('analytics')->as('analytic.')->group(function() {
            Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        });

        Route::prefix('profile')->as('profile.')->group(function() {
            Route::post('/', [ProfileController::class, 'selectLibraryAvatar'])->name('select_library_avatar');
        });

        Route::prefix('sync')->as('sync.')->group(function () {
            Route::post('/', [SynchronizationController::class, 'sync'])->name('synchronize');
        });

        Route::prefix('exchange-rates')->as('exchange_rates.')->group(function () {
            Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
        });

        Route::prefix('notifications')->as('notification.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
        });

        Route::middleware('admin')->group(function () {
            Route::prefix('meta')->as('meta.')->group(function () {
                Route::get('processes', [MetaController::class, 'processes'])->name('processes');
                Route::get('jobs', [MetaController::class, 'jobs'])->name('jobs');
            });
        });

        Route::prefix('reports')->as('report.')->group(function () {
            Route::get('avg-expenditures', [ReportController::class, 'avgExpenditures'])
                ->name('avg_expenditures');
            Route::get('avg-incomes', [ReportController::class, 'avgIncomes'])
                ->name('avg_incomes');
        });
    });
});
