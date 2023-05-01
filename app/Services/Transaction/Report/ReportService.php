<?php

namespace App\Services\Transaction\Report;

use App\Models\Transaction\Transaction;
use Illuminate\Support\Carbon;

class ReportService
{
    public function getMonthReport(Carbon $carbon): array
    {
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
                'period' => $carbon->format('m-Y')
            ],

            'transactions_count' => Transaction::whereMonthAndYear($carbon)->count(),

            'expenditures_count' => Transaction::whereMonthAndYear($carbon)
                ->whereExpenditure()
                ->count(),

            'incomes_count' => Transaction::whereMonthAndYear($carbon)
                ->whereIncome()
                ->count(),

            'expenditures_sum' => Transaction::whereMonthAndYear($carbon)
                ->whereExpenditure()
                ->sum(Transaction::CALCULATION_COLUMN),

            'incomes_sum' => Transaction::whereMonthAndYear($carbon)
                ->whereIncome()
                ->sum(Transaction::CALCULATION_COLUMN),

            'top_5_biggest_incomes' => Transaction::whereMonthAndYear($carbon)
                ->whereIncome()
                ->select($columnsSelected)
                ->orderBy('calculation_volume', 'desc')
                ->limit(5)
                ->get(),

            'top_5_biggest_expenditures' => Transaction::whereMonthAndYear($carbon)
                ->whereExpenditure()
                ->select($columnsSelected)
                ->orderBy('calculation_volume', 'desc')
                ->limit(5)
                ->get(),
        ];
    }
}
