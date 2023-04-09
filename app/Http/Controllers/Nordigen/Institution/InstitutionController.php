<?php

namespace App\Http\Controllers\Nordigen\Institution;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class InstitutionController extends Controller
{
    public function __construct(private TransactionSyncServiceInterface $transactionSyncService) { }

    public function index(): View
    {
        $institutions = $this->transactionSyncService->provideSupportedInstitutionsData();
        $agreements   = $this->transactionSyncService->getAgreements();
        return view('nordigen.institution.index', compact('institutions', 'agreements'));
    }

    public function select(mixed $id): View
    {
        $selectedInstitution = $this->transactionSyncService->getInstitutionByExternalId($id);
        $existingAgreement   = $this->transactionSyncService->getExistingAgreementForInstitution($id);

        return view('nordigen.institution.select', [
                'institution'       => $selectedInstitution,
                'existingAgreement' => $existingAgreement,
            ]
        );
    }

    public function agreements(mixed $id): View
    {
        $agreements  = $this->transactionSyncService->getAgreementsByInstitution($id);
        $institution = $this->transactionSyncService->getInstitutionByExternalId($id);
        return view('nordigen.institution.agreements', compact('agreements', 'institution'));
    }

    public function newAgreement(mixed $institutionId): RedirectResponse
    {
        $this->transactionSyncService->createNewUserAgreement($institutionId);
        return redirect(route('institution.index'));
    }

    public function newRequisition(mixed $agreementId): RedirectResponse
    {
        $agreement     = $this->transactionSyncService->getAgreementById($agreementId);
        $institutionId = $agreement->getInstitutionId();
        $this->transactionSyncService->createNewRequisition($institutionId, $agreementId);

        return redirect(route('institution.agreements', ['id' => $institutionId]));
    }
}
