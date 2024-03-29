<?php

namespace App\Http\Controllers\Web\Nordigen\Institution;

use Throwable;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class InstitutionController extends Controller
{
    public function __construct(private readonly TransactionSyncServiceInterface $transactionSyncService)
    {
    }

    public function index(Request $request): View|RedirectResponse
    {
        try {
            $user = $request->user();
            $institutions = $this->transactionSyncService->provideSupportedInstitutionsData();
            $agreements = $this->transactionSyncService->getAgreements($user);

            return view('nordigen.institution.index', compact('institutions', 'agreements'));

        } catch (Throwable) {
            return back()
                ->with(config('session.flash_errors_key'), [
                    __('Cannot fetch institutions data.')
                ]);
        }
    }

    public function select(mixed $id, Request $request): View
    {
        $user = $request->user();
        $selectedInstitution = $this->transactionSyncService->getInstitutionByExternalId($id);
        $existingAgreement = $this->transactionSyncService->getExistingAgreementForInstitution($user, $id);

        return view(
            'nordigen.institution.select',
            [
                'institution' => $selectedInstitution,
                'existingAgreement' => $existingAgreement,
            ]
        );
    }

    public function agreements(mixed $id, Request $request): View
    {
        $user = $request->user();
        $agreements = $this->transactionSyncService->getAgreementsByInstitution($user, $id);
        $institution = $this->transactionSyncService->getInstitutionByExternalId($id);

        return view('nordigen.institution.agreements', compact('agreements', 'institution'));
    }

    public function newAgreement(mixed $institutionId, Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->transactionSyncService->createNewUserAgreement($user, $institutionId);

        return to_route('institution.index');
    }

    public function newRequisition(mixed $agreementId, Request $request): RedirectResponse
    {
        $user = $request->user();
        $agreement = $this->transactionSyncService->getAgreementById($user, $agreementId);
        $institutionId = $agreement->getInstitutionId();
        $this->transactionSyncService->createNewRequisition($institutionId, $agreementId, $user);

        return to_route('institution.agreements', ['id' => $institutionId]);
    }

    public function deleteAgreement(mixed $agreementId, Request $request): RedirectResponse
    {
        $user = $request->user();
        $agreement = $this->transactionSyncService->getAgreementById($user, $agreementId);
        $agreement->delete();

        return back();
    }
}
