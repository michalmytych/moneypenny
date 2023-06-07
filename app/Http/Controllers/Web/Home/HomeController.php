<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Synchronization\Synchronization;
use App\Services\HomePage\HomePageService;
use App\Services\Notification\NotificationService;
use App\Services\Transaction\Budget\BudgetService;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\PersonalAccount\SaldoService;
use App\Services\Transaction\TransactionQuerySet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly SaldoService        $saldoService,
        private readonly BudgetService       $budgetService,
        private readonly HomePageService     $homePageService,
        private readonly CurrencyService     $currencyService,
        private readonly TransactionQuerySet $transactionQuerySet,
        private readonly NotificationService $notificationService
    )
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $budgets = $this->budgetService->allWithConsumption($user);
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);
        $eventNotifications = $this->notificationService->allEvents($user, 4);
        $expendituresTodayTotal = $this->transactionQuerySet->getExpendituresTodayTotal($user);
        $expendituresThisWeekTotal = $this->transactionQuerySet->getExpendituresThisWeekTotal($user);
        $incomesTodayTotal = $this->transactionQuerySet->getIncomesTodayTotal($user);
        $incomesThisWeekTotal = $this->transactionQuerySet->getIncomesThisWeekTotal($user);

        return view(
            'home.index',
            [
                'currencyCode' => $currencyCode,
                'budgetsWithConsumption' => $budgets,
                'eventNotifications' => $eventNotifications,
                'transactionsData' => $this->homePageService->getLatestTransactionsData($user),
                'saldoData' => $this->saldoService->getByUser($user),
                'synchronizationsCount' => Synchronization::count(), // @todo
                'endUserAgreementCount' => EndUserAgreement::count(), // @todo,
                'expendituresTodayTotal' => $expendituresTodayTotal,
                'expendituresThisWeekTotal' => $expendituresThisWeekTotal,
                'incomesTodayTotal' => $incomesTodayTotal,
                'incomesThisWeekTotal' => $incomesThisWeekTotal
            ]
        );
    }
}
