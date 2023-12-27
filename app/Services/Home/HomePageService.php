<?php

namespace App\Services\Home;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Services\Transaction\TransactionQuerySet;
use App\Services\Notification\NotificationService;
use App\Services\Transaction\Budget\BudgetService;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\PersonalAccount\SaldoService;
use App\Services\Transaction\Synchronization\SynchronizationService;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class HomePageService implements HomePageServiceInterface
{
    public function __construct(
        private readonly SaldoService                    $saldoService,
        private readonly BudgetService                   $budgetService,
        private readonly CurrencyService                 $currencyService,
        private readonly NotificationService             $notificationService,
        private readonly TransactionQuerySet             $transactionQuerySet,
        private readonly SynchronizationService          $synchronizationService,
        private readonly TransactionSyncServiceInterface $transactionSyncService,
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
            'synchronizationsCount' => $this->synchronizationService->countByUser($user),
            'endUserAgreementCount' => $this->synchronizationService->getEndUserAgreementsCountByUser($user),
            'transactionsData' => [
                'agreement' => $this->transactionSyncService->getAgreements($user)->first(),
                'transactions' => $this->transactionQuerySet->getTenLatestTransactionsByUserForHomePage($user),
                'last_synchronization' => $this->synchronizationService->getLatestSucceededByUser($user)
            ]
        ]);
    }
}
