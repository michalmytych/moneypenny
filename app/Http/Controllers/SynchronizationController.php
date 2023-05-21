<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Services\Nordigen\NordigenAccountService;
use App\Services\Transaction\Synchronization\SynchronizationService;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class SynchronizationController extends Controller
{
    public function __construct(
        private readonly NordigenAccountService $nordigenAccountService,
        private readonly SynchronizationService          $synchronizationService,
        private readonly TransactionSyncServiceInterface $transactionSyncService
    )
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $synchronizations = $this->synchronizationService->all($user);
        return view('synchronizations.index', compact('synchronizations'));
    }

    public function sync(Request $request): JsonResponse
    {
        $user = $request->user();
        $agreementId = $request->get('agreement_id');

        $requisition = $this->synchronizationService->checkRequisition($user, $agreementId);
        $synchronization = $this->synchronizationService->create($user);

        try {
            $this->transactionSyncService->syncAccounts($requisition->nordigen_requisition_id, $synchronization->id, $user);
            $this->transactionSyncService->syncTransactions($requisition->nordigen_requisition_id, $synchronization->id, $user);
            $this->transactionSyncService->setStatusSucceeded($synchronization);

        } catch (Throwable $throwable) {
            $this->transactionSyncService->setStatusFailed($synchronization);
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
