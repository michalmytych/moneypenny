<?php

use App\Http\Controllers\Web\Transaction\PersonaController;
use Illuminate\Support\Facades\Route;

Route::prefix('personas')->as('persona.')->group(function () {
    Route::get('/', [PersonaController::class, 'index'])->name('index');
    Route::patch('/{persona}', [PersonaController::class, 'update'])->name('update');
    Route::get('/mass-association', [PersonaController::class, 'associatePersonasToTransactions']);
});
