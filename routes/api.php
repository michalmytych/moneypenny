<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SynchronizationController;
use App\Http\Controllers\Analysis\AnalysisController;

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

Route::post('/analysis', [AnalysisController::class, 'analyze'])->name('api.analysis');
Route::post('/sync', [SynchronizationController::class, 'sync'])->name('api.sync');

// @todo
Route::get(
    '/test',
    function () {
//        return app(\App\Services\Analysis\AnalysisService::class)->analyze([
//            'analyzer_type' => 'transaction_count_per_day'
//            'analyzer_type' => 'transaction_volume_sum_per_day'
//            'analyzer_type' => 'total_transaction_volume_per_week_day'
//            'analyzer_type' => 'total_transactions_volume',
//        ]);
//        return app(\App\Nordigen\NordigenService::class)->provideSupportedInstitutionsData();
    }
)->name('api.test');
