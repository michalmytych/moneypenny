<?php

use App\Http\Controllers\Web\Nordigen\Institution\InstitutionController;
use Illuminate\Support\Facades\Route;

Route::prefix('institutions')->as('institution.')->group(function () {
    Route::get('/', [InstitutionController::class, 'index'])->name('index');
    Route::get('/{id}/select', [InstitutionController::class, 'select'])->name('select');
    Route::post('/{institutionId}', [InstitutionController::class, 'newAgreement'])->name('new_agreement');
    Route::get('/{id}/agreements', [InstitutionController::class, 'agreements'])->name('agreements');
    Route::post('/{agreementId}/requisitions', [InstitutionController::class, 'newRequisition'])->name('new_requisition');
    Route::delete('/agreements/{agreementId}', [InstitutionController::class, 'deleteAgreement'])->name('delete_agreement');
});
