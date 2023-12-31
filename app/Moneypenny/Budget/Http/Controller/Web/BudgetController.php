<?php

namespace App\Moneypenny\Budget\Http\Controller\Web;

use App\Moneypenny\Transaction\Http\Requests\Web\CreateBudgetRequest;
use App\Moneypenny\Transaction\Http\Requests\Web\PatchBudgetRequest;
use App\Shared\Http\Controller\Controller;
use App\Transaction\Budget\BudgetService;
use App\Transaction\Currency\CurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function __construct(
        private readonly BudgetService $budgetService,
        private readonly CurrencyService $currencyService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $budgets = $this->budgetService->allWithConsumption($user);
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);

        return view('budgets.index', compact('budgets', 'currencyCode'));
    }

    public function show(mixed $id, Request $request): View
    {
        $user = $request->user();
        $budget = $this->budgetService->findOrFail($id, $user);
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);

        return view('budgets.show', compact('budget', 'currencyCode'));
    }

    public function new(Request $request): View
    {
        $user = $request->user();
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);

        return view('budgets.new', compact('currencyCode'));
    }

    public function create(CreateBudgetRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $this->budgetService->create($user, $data);

        return to_route('budget.index');
    }

    public function edit(mixed $id, Request $request): View
    {
        $user = $request->user();
        $budget = $this->budgetService->findOrFail($id, $user);
        $currencyCode = $this->currencyService->resolveCalculationCurrency($user);

        return view('budgets.edit', compact('budget', 'currencyCode'));
    }

    public function patch(mixed $id, PatchBudgetRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $budget = $this->budgetService->findOrFail($id, $user);
        $this->budgetService->update($budget, $data);

        return to_route('budget.show', ['id' => $id]);
    }
}
