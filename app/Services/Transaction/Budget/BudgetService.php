<?php

namespace App\Services\Transaction\Budget;

use App\Models\User;
use App\Models\Transaction\Budget;
use Illuminate\Support\Collection;

class BudgetService
{
    public function __construct(
        private readonly DefaultBudgetService $defaultBudgetService,
        private readonly BudgetConsumtptionService $budgetConsumtptionService
    ) {}

    public function allWithConsumption(User $user): Collection
    {
        $this->defaultBudgetService->getOrCreateBudgetsForUser($user);
        return $this->budgetConsumtptionService->getBudgetsConsumptionByUser($user);
    }

    public function create(mixed $user, mixed $data): Budget
    {
        $user['user_id'] = $user->id;
        return Budget::create($data);
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
