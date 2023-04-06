<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Import\ImportSettingController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('files')->as('file.')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('index');
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    Route::get('{id}', [FileController::class, 'show'])->name('show');
});

Route::prefix('imports')->as('import.')->group(function () {
    Route::prefix('settings')->as('import-setting.')->group(function () {
        Route::get('/', [ImportSettingController::class, 'index'])->name('index');
        Route::get('/{id}', [ImportSettingController::class, 'show'])->name('show');
        Route::post('/', [ImportSettingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ImportSettingController::class, 'edit'])->name('edit');
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
