<?php

namespace App\Moneypenny\Home\Services;

use App\Moneypenny\Home\Contracts\HomePageServiceInterface;
use App\Moneypenny\Transaction\Contracts\TransactionSyncServiceInterface;
use App\Moneypenny\User\Models\User;
use App\Notification\Services\NotificationService;
use App\Transaction\Budget\BudgetService;
use App\Transaction\Currency\CurrencyService;
use App\Transaction\PersonalAccount\SaldoService;
use App\Transaction\Synchronization\SynchronizationService;
use App\Transaction\Transaction\TransactionQuerySet;
use Illuminate\Support\Collection;

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
            'expendituresTodayTotal' => $this->transactionQuerySet->getExpendituresTodayTotal($user),
            'eventNotifications' => $this->notificationService->allEvents($user, 4), // @todo - test
            'saldoData' => $this->saldoService->getByUser($user), // @todo - change & test
            'expendituresThisWeekTotal' => $this->transactionQuerySet->getExpendituresThisWeekTotal($user),
            'incomesTodayTotal' => $this->transactionQuerySet->getIncomesTodayTotal($user),
            'incomesThisWeekTotal' => $this->transactionQuerySet->getIncomesThisWeekTotal($user),
            'synchronizationsCount' => $this->synchronizationService->countByUser($user),
            'endUserAgreementCount' => $this->synchronizationService->getEndUserAgreementsCountByUser($user),
            'transactionsData' => [
                'agreement' => $this->transactionSyncService->getAgreements($user)->first(), // @todo - test & change - should show 'default' synchronization
                'transactions' => $this->transactionQuerySet->getTenLatestTransactionsByUserForHomePage($user),
                'last_synchronization' => $this->synchronizationService->getLatestSucceededByUser($user)
            ]
        ]);
    }
}
