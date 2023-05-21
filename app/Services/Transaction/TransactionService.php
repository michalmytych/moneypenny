<?php

namespace App\Services\Transaction;

use App\Models\User;
use App\Filters\Filter;
use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use Illuminate\Support\Carbon;

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

    public function create(User $user, array $data): Transaction
    {
        $decimalVolume = (float) $data['decimal_volume'];
        $type = (int) $data['type'];
        $transactionDate = Carbon::parse($data['transaction_date']);

        $attributes = [
            'user_id' => $user->id,
            'type' => $type,
            'sender' => $data['sender'],
            'receiver' => $data['receiver'],
            'currency' => $data['currency'],
            'decimal_volume' => $decimalVolume,
            'calculation_volume' => $decimalVolume,
            'raw_volume' => TransactionHelper::createRawVolume($decimalVolume, $type),
            'description' => $data['description'],
            'accounting_date' => $transactionDate,
            'transaction_date' => $transactionDate
        ];

        return Transaction::create($attributes);
    }
}
