<?php

namespace App\Services\Transaction\Report\Defaults;

use App\Models\Transaction\Transaction;
use Illuminate\Contracts\Auth\Authenticatable;

class MonthReport extends ReportTemplate
{
    public function getReportData(Authenticatable $user): array
    {
        $selectedMonth = $this->params['selected_month'];

        $columnsSelected = [
            'receiver_account_number',
            'sender_account_number',
            'receiver_persona_id',
            'calculation_volume',
            'sender_persona_id',
            'transaction_date',
            'accounting_date',
            'description',
            'raw_volume',
            'receiver',
            'currency',
        ];

        return [
            'meta' => [
                'period' => $selectedMonth->format('m-Y')
            ],

            'transactions_count' => Transaction::whereMonthAndYear($selectedMonth)->count(),

            'expenditures_count' => Transaction::whereMonthAndYear($selectedMonth)
                ->whereExpenditure()
                ->count(),

            'incomes_count' => Transaction::whereMonthAndYear($selectedMonth)
                ->whereIncome()
                ->count(),

            'expenditures_sum' => Transaction::whereMonthAndYear($selectedMonth)
                ->whereExpenditure()
                ->sum(Transaction::CALCULATION_COLUMN),

            'incomes_sum' => Transaction::whereMonthAndYear($selectedMonth)
                ->whereIncome()
                ->sum(Transaction::CALCULATION_COLUMN),

            'top_5_biggest_incomes' => Transaction::whereMonthAndYear($selectedMonth)
                ->whereIncome()
                ->select($columnsSelected)
                ->orderBy(Transaction::CALCULATION_COLUMN, 'desc')
                ->limit(5)
                ->get(),

            'top_5_biggest_expenditures' => Transaction::whereMonthAndYear($selectedMonth)
                ->whereExpenditure()
                ->select($columnsSelected)
                ->orderBy(Transaction::CALCULATION_COLUMN, 'desc')
                ->limit(5)
                ->get(),
        ];
    }
}
