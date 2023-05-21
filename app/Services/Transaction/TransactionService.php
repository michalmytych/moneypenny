<?php

namespace App\Services\Transaction;

use App\Models\User;
use App\Filters\Filter;
use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;

class TransactionService
{
    public function getIndexData(Filter $filter, User $user): array
    {
        $transactions = Transaction::applyFilter($filter)
            ->whereUser($user)
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

    public function findOrFail(mixed $id, User $user): ?Transaction
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        return $transaction;
    }
}
