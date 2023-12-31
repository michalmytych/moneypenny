<?php

namespace App\Transaction\Budget;

use App\Moneypenny\Budget\Models\Budget;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Collection;

readonly class BudgetService
{
    public function __construct(
        private DefaultBudgetService      $defaultBudgetService,
        private BudgetConsumtptionService $budgetConsumptionService
    ) {}

    public function allWithConsumption(User $user): Collection
    {
        $this->defaultBudgetService->getOrCreateBudgetsForUser($user);

        return $this->budgetConsumptionService->getBudgetsConsumptionByUser($user);
    }

    public function create(mixed $user, mixed $data): Budget
    {
        $data['user_id'] = $user->id;

        return Budget::create($data);
    }

    public function update(Budget $budget, mixed $data): Budget
    {
        return tap($budget)->update($data);
    }

    public function findOrFail(int $id, mixed $user): Budget
    {
        $budget = Budget::where([
            'id' => $id,
            'user_id' => $user->id,
        ])
            ->get()
            ->first();

        if (!$budget) {
            abort(404);
        }

        return $budget;
    }
}
