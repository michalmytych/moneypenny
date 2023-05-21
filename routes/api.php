<?php

use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Transaction\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SynchronizationController;
use App\Http\Controllers\Analysis\AnalysisController;
use App\Http\Controllers\ExchangeRates\ExchangeRateController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->as('api.')->group(function() {
    Route::prefix('analysis')->as('analysis.')->group(function() {
        Route::post('/', [AnalysisController::class, 'analyze'])->name('analyze');
    });

    Route::prefix('sync')->as('sync.')->group(function() {
        Route::post('/', [SynchronizationController::class, 'sync'])->name('sync');
    });

    Route::prefix('exchange-rates')->as('exchange_rates.')->group(function() {
        Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
    });

    Route::prefix('notifications')->as('notification.')->group(function() {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
    });

    Route::prefix('meta')->as('meta.')->group(function() {
        Route::get('processes', [MetaController::class, 'processes'])->name('processes');
    });

    Route::prefix('reports')->as('report.')->group(function() {
        Route::get('avg-expenditures', [ReportController::class, 'avgExpenditures'])->name('avg_expenditures');
        Route::get('avg-incomes', [ReportController::class, 'avgIncomes'])->name('avg_incomes');
    });
});
