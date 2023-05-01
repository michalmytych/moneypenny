<?php

use App\Http\Controllers\EmptyController;
use App\Http\Controllers\ExchangeRates\ExchangeRateController;
use App\Http\Controllers\Meta\MetaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SynchronizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Import\ImportController;
use App\Http\Controllers\Import\ImportSettingController;
use App\Http\Controllers\Import\ColumnsMappingController;
use App\Http\Controllers\Nordigen\Institution\InstitutionController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reports')->as('report.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/periodic', [ReportController::class, 'periodic'])->name('periodic');
    });

    Route::prefix('meta')->as('meta.')->group(function () {
        Route::get('/', [MetaController::class, 'index'])->name('index');
    });

    Route::prefix('personas')->as('persona.')->group(function () {
        Route::get('/', [PersonaController::class, 'index'])->name('index');
        Route::patch('/{persona}', [PersonaController::class, 'update'])->name('update');
        Route::get('/mass-association', [PersonaController::class, 'associatePersonasToTransactions']);
    });

    Route::prefix('debug')->as('debug.')->group(function () {
        Route::get('/analyzers', [DebugController::class, 'analyzers'])->name('analyzers');
    });

    Route::prefix('exchange-rates')->as('exchange-rate.')->group(function () {
        Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
    });

    Route::prefix('files')->as('file.')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('index');
        Route::post('/upload', [FileController::class, 'upload'])->name('upload');
        Route::get('{id}', [FileController::class, 'show'])->name('show');
    });

    Route::prefix('synchronizations')->as('synchronization.')->group(function () {
        Route::get('/', [SynchronizationController::class, 'index'])->name('index');
    });

    Route::prefix('institutions')->as('institution.')->group(function () {
        Route::get('/', [InstitutionController::class, 'index'])->name('index');
        Route::get('/{id}/select', [InstitutionController::class, 'select'])->name('select');
        Route::post('/{institutionId}', [InstitutionController::class, 'newAgreement'])->name('new_agreement');
        Route::get('/{id}/agreements', [InstitutionController::class, 'agreements'])->name('agreements');
        Route::post('/{agreementId}/requisitions', [InstitutionController::class, 'newRequisition'])->name('new_requisition');
    });

    Route::prefix('transactions')->as('transaction.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
    });

    Route::prefix('imports')->as('import.')->group(function () {
        Route::get('/', [ImportController::class, 'index'])->name('index');

        Route::prefix('settings')->as('import-setting.')->group(function () {
            Route::get('/', [ImportSettingController::class, 'index'])->name('index');
            Route::get('/{id}', [ImportSettingController::class, 'show'])->name('show');
            Route::post('/', [ImportSettingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ImportSettingController::class, 'edit'])->name('edit');
        });

        Route::prefix('columns-mappings')->as('columns-mapping.')->group(function () {
            Route::get('/', [ColumnsMappingController::class, 'index'])->name('index');
            Route::post('/', [ColumnsMappingController::class, 'store'])->name('store');
        });
    });

    Route::get('/', [EmptyController::class, 'redirect'])->name('empty');
});

require __DIR__ . '/auth.php';
