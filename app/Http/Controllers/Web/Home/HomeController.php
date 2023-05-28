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
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly SaldoService $saldoService,
        private readonly BudgetService $budgetService,
        private readonly HomePageService $homePageService,
        private readonly CurrencyService $currencyService,
        private readonly NotificationService $notificationService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $budgets = $this->budgetService->allWithConsumption($user);
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);
        $eventNotifications = $this->notificationService->allEvents($user, 4);

        return view(
            'home.index',
            [
                'currencyCode' => $currencyCode,
                'budgetsWithConsumption' => $budgets,
                'eventNotifications' => $eventNotifications,
                'transactionsData' => $this->homePageService->getLatestTransactionsData($user),
                'saldoData' => $this->saldoService->getByUser($user),
                'synchronizationsCount' => Synchronization::count(), // @todo
                'endUserAgreementCount' => EndUserAgreement::count() // @todo
            ]
        );
    }
}
