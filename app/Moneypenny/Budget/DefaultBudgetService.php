<?php

namespace App\Transaction\Budget;

use App\Moneypenny\Budget\Models\Budget;
use App\Moneypenny\User\Models\User;
use Illuminate\Support\Collection;

class DefaultBudgetService
{
    public function getOrCreateBudgetsForUser(User $user): Collection
    {
        $usersBudgets = $user // @todo - move to service
            ->budgets()
            ->latest()
            ->get();

        if ($usersBudgets->count() > 0) {
            return $usersBudgets;
        }

        $usersMoneySum = $user // @todo - move to service, should sum taking currency into account
            ->personalAccounts()
            ->latest()
            ->get()
            ->sum('value');

        $usersMoneySum = $usersMoneySum ?: 5000;
        $monthBudgetValue = $usersMoneySum / 2; // @todo just take previous months expenses
        $weekBudgetValue = $monthBudgetValue / 4;
        $dayBudgetValue = $weekBudgetValue / 30;

        $defaultBudgetsData = [
            [
                'user_id' => $user->id,
                'amount' => round($monthBudgetValue),
                'type' => Budget::TYPE_MONTH,
                'name' => 'general budget'
            ],
            [
                'user_id' => $user->id,
                'amount' => round($weekBudgetValue),
                'type' => Budget::TYPE_WEEK,
                'name' => 'general budget'
            ],
            [
                'user_id' => $user->id,
                'amount' => round($dayBudgetValue),
                'type' => Budget::TYPE_DAY,
                'name' => 'general budget'
            ],
        ];

        Budget::insert($defaultBudgetsData);

        return $user
            ->refresh()
            ->budgets()
            ->latest()
            ->get();
    }
}
