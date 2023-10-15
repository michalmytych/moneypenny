<?php

namespace App\Http\Controllers\Web\Transaction;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Transaction\Budget\BudgetService;
use App\Http\Requests\Web\Transaction\CreateRequest;
use App\Services\Transaction\Currency\CurrencyService;
use App\Http\Requests\Web\Transaction\Budget\PatchRequest;

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

    public function new(): View
    {
        return view('budgets.new');
    }

    public function create(CreateRequest $request): RedirectResponse
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

    public function patch(mixed $id, PatchRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $budget = $this->budgetService->findOrFail($id, $user);
        $this->budgetService->update($budget, $data);

        return to_route('budget.show', ['id' => $id]);
    }
}
