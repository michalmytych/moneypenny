<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Models\Nordigen\Requisition;
use App\Models\Synchronization\Account;
use App\Models\Synchronization\Synchronization;
use App\Services\Transaction\Synchronization\SynchronizationService;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class SynchronizationController extends Controller
{
    public function __construct(
        private readonly SynchronizationService          $synchronizationService,
        private readonly TransactionSyncServiceInterface $transactionSyncService
    )
    {
    }

    public function index(): View
    {
        $synchronizations = $this->synchronizationService->all();
        return view('synchronizations.index', compact('synchronizations'));
    }

    public function sync(Request $request): JsonResponse
    {
        $agreementId = $request->get('agreement_id');
        $requisition = Requisition::latest()->firstWhere('end_user_agreement_id', $agreementId);
        $synchronization = Synchronization::create();

        try {
            $this->transactionSyncService->syncAccounts($requisition->nordigen_requisition_id, $synchronization->id);
            $this->transactionSyncService->syncTransactions($requisition->nordigen_requisition_id, $synchronization->id);
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

        return response()->json(Account::all());
    }
}
