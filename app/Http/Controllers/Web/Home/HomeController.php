<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Synchronization\Synchronization;
use App\Services\HomePage\HomePageService;
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
        private readonly CurrencyService $currencyService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $budgets = $this->budgetService->allWithConsumption($user);
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);

        return view(
            'home.index',
            [
                'budgetsWithConsumption' => $budgets,
                'currencyCode' => $currencyCode,
                'transactionsData' => $this->homePageService->getLatestTransactionsData($user),
                'saldoData' => $this->saldoService->getByUser($user),
                'synchronizationsCount' => Synchronization::count(), // @todo
                'endUserAgreementCount' => EndUserAgreement::count() // @todo
            ]
        );
    }
}
