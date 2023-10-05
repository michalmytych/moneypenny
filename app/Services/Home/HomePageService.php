<?php

namespace App\Services\Home;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\Transaction\Transaction;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Synchronization\Synchronization;
use App\Services\Transaction\TransactionQuerySet;
use App\Services\Notification\NotificationService;
use App\Services\Transaction\Budget\BudgetService;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\PersonalAccount\SaldoService;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class HomePageService implements HomePageServiceInterface
{
    public function __construct(
        private readonly SaldoService                    $saldoService,
        private readonly BudgetService                   $budgetService,
        private readonly CurrencyService                 $currencyService,
        private readonly NotificationService             $notificationService,
        private readonly TransactionQuerySet             $transactionQuerySet,
        private readonly TransactionSyncServiceInterface $transactionSyncService
    )
    {
    }

    public function getHomeData(User $user): Collection
    {
        return collect([
            'user' => $user,
            'budgetsWithConsumption' => $this->budgetService->allWithConsumption($user),
            'currencyCode' => $this->currencyService->resolveCalculationCurrency($user),
            'eventNotifications' => $this->notificationService->allEvents($user, 4),
            'expendituresTodayTotal' => $this->transactionQuerySet->getExpendituresTodayTotal($user),
            'saldoData' => $this->saldoService->getByUser($user),
            'expendituresThisWeekTotal' => $this->transactionQuerySet->getExpendituresThisWeekTotal($user),
            'incomesTodayTotal' => $this->transactionQuerySet->getIncomesTodayTotal($user),
            'incomesThisWeekTotal' => $this->transactionQuerySet->getIncomesThisWeekTotal($user),
            'synchronizationsCount' => Synchronization::count(), // @todo
            'endUserAgreementCount' => EndUserAgreement::count(), // @todo,
            'transactionsData' => [
                'agreement' => $this
                    ->transactionSyncService
                    ->getAgreements($user)
                    ->first(),
                'transactions' => Transaction::whereUser($user)
                    ->orderByTransactionDate()
                    ->limit(10)
                    ->get(),
                'last_synchronization' => Synchronization::whereUser($user)
                    ->where('status', Synchronization::SYNC_STATUS_SUCCEEDED)
                    ->with('import')
                    ->latest()
                    ->limit(1)
                    ->get()
                    ->first()
            ]
        ]);
    }
}
