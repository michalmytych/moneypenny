<?php

namespace App\Http\Controllers\Institution;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class InstitutionController extends Controller
{
    public function __construct(private TransactionSyncServiceInterface $transactionSyncService) { }

    public function index(): View
    {
        $institutions = $this->transactionSyncService->provideSupportedInstitutionsData();
        return view('institution.index', ['institutions' => $institutions]);
    }

    public function select(mixed $id): View
    {
        $selectedInstitution = $this->transactionSyncService->getInstitutionByExternalId($id);
        $existingAgreement   = $this->transactionSyncService->getExistingAgreementForInstitution($id);

        return view('institution.select', [
                'institution'       => $selectedInstitution,
                'existingAgreement' => $existingAgreement,
            ]
        );
    }

    public function newAgreement(mixed $institutionId): View
    {
        $selected = $this->transactionSyncService->getInstitutionByExternalId($institutionId);
        $agreement = $this->transactionSyncService->createNewUserAgreement($institutionId);

        dd(is_array($agreement) ? $agreement : $agreement->toArray());

        return view('institution.select', ['institution' => $selected]);
    }
}
