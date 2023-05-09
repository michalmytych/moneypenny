<?php

namespace App\Services\Transaction;

use App\Filters\Filter;
use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;

class TransactionService
{
    public function getIndexData(Filter $filter): array
    {
        $transactions = Transaction::applyFilter($filter)
            ->orderBy('transaction_date', 'desc')
            ->limit(1000)
            ->get();

        $filterableColumns = Transaction::getFilterableColumns();
        $personas = Persona::orderBy('common_name')->get();

        return [
            'transactions' => $transactions,
            'filterableColumns' => $filterableColumns,
            'personas' => $personas
        ];
    }

    public function findOrFail(mixed $id): ?Transaction
    {
        return Transaction::findOrFail($id);
    }
}
