<?php

namespace App\Http\Controllers\Api\Synchronization;

use App\Http\Controllers\Controller;
use App\Moneypenny\Transaction\Contracts\TransactionSyncServiceInterface;
use App\Nordigen\Services\NordigenAccountService;
use App\Transaction\Synchronization\SynchronizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Throwable;

class SynchronizationController extends Controller
{
    public function __construct(
        private readonly NordigenAccountService          $nordigenAccountService,
        private readonly SynchronizationService          $synchronizationService,
        private readonly TransactionSyncServiceInterface $transactionSyncService
    )
    {
    }

    public function sync(Request $request): JsonResponse
    {
        $user = $request->user();
        $agreementId = $request->get('agreement_id');

        $requisition = $this->synchronizationService->getLastRequisitionByAgreement($user, $agreementId);
        $synchronization = $this->synchronizationService->create($user);

        try {
            $this->transactionSyncService->syncTransactions($requisition->nordigen_requisition_id, $synchronization->id, $user);
            $this->transactionSyncService->setStatusSucceeded($synchronization);

        } catch (Throwable $throwable) {
            $this->transactionSyncService->setStatusFailed($synchronization, $throwable->getCode());
            $statusCode = $throwable->getCode();

            $supportedStatuses = [500, 429, 408];
            $statusCode = in_array($throwable->getCode(), $supportedStatuses) ? $statusCode : 500;

            return response()->json([
                'error' => 'Synchronization error',
                'details' => App::hasDebugModeEnabled() ? $throwable->getMessage() : 'Lacking permissions',
                'status_code' => $statusCode,
            ], $statusCode);
        }

        $accounts = $this->nordigenAccountService->all($user);

        return response()->json($accounts);
    }
}
