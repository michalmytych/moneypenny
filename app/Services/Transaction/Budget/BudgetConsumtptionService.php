<?php

namespace App\Services\Transaction\Budget;

use App\Models\User;
use App\Models\Transaction\Budget;
use Illuminate\Support\Collection;
use App\Services\Helpers\CalendarHelper;
use App\Services\Transaction\TransactionQuerySet;

class BudgetConsumtptionService
{
    public function __construct(private readonly TransactionQuerySet $transactionQuerySet)
    {
    }

    public function getBudgetsConsumptionByUser(User $user): Collection
    {
        $budgets = $user->budgets;
        $budgetsConsumptionData = collect();

        foreach ($budgets as $budget) {
            $periodExpendituresSum = 0;

            if ($budget->type === Budget::TYPE_MONTH) {
                $monthDates = CalendarHelper::getMonthDates();
                $periodExpendituresSum = $this
                    ->transactionQuerySet
                    ->getExpendituresSumByDates($user, $monthDates);
            }

            if ($budget->type === Budget::TYPE_WEEK) {
                $weekDates = CalendarHelper::getWeekDates(now());
                $periodExpendituresSum = $this
                    ->transactionQuerySet
                    ->getExpendituresSumByDates($user, $weekDates);
            }

            $budgetsConsumptionData->push(
                [
                'budget' => $budget,
                'budget_amount' => (float) $budget->amount,
                'period_expenditures_sum' => (float) $periodExpendituresSum,
                'consumption' => (float) abs($periodExpendituresSum / $budget->amount),
                ]
            );
        }

        return $budgetsConsumptionData;
    }
}
