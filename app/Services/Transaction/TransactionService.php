<?php

namespace App\Services\Transaction;

use App\Models\User;
use App\Filters\Filter;
use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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
        $relationsToLoad = [
            'import',
            'synchronization',
            'account',
            'category',
            'senderPersona',
            'receiverPersona',
        ];

        /** @var Transaction $transaction */
        $transaction = Transaction::with($relationsToLoad)->findOrFail($id);

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

    public function getSimilarTransactions(?Transaction $transaction): Collection
    {
        // @todo - improve search
        if (!$transaction) {
            return collect();
        }

        return Transaction::whereUser($transaction->user)
            ->where('id', '!=', $transaction->id)
            ->where('description', 'like', '%' . $transaction->description . '%')
            ->where('receiver', 'like', '%' . $transaction->receiver . '%')
            ->where('sender', 'like', '%' . $transaction->sender . '%')
            ->limit(10)
            ->get();
    }
}
