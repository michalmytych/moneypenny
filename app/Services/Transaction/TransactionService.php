<?php

namespace App\Services\Transaction;

use App\Models\User;
use App\Filters\Filter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use App\Services\Transaction\Similar\SimilarTransactionsService;

class TransactionService
{
    public function __construct(private readonly SimilarTransactionsService $similarTransactionsService)
    {
    }

    public function getIndexData(Filter $filter, User $user): array
    {
        $transactions = Transaction::applyFilter($filter)
            ->whereUser($user)
            ->orderBy('transaction_date', 'desc')
            ->with('category')
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

        /**
 * @var Transaction $transaction 
*/
        $transaction = Transaction::with($relationsToLoad)->findOrFail($id);

        if ($transaction->user_id !== $user->id) {
            abort(403);
        }

        return $transaction;
    }

    public function create(User $user, array $data): Transaction
    {
        $decimalVolume = (float)$data['decimal_volume'];
        $type = (int)$data['type'];
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
        if (!$transaction) {
            return collect();
        }

        return $this->similarTransactionsService->getSimilarTransactions($transaction);
    }

    public function toggleExcludeFromCalculation(mixed $transactionId): void
    {
        $transaction = Transaction::find($transactionId);
        $transaction->is_excluded_from_calculation = !$transaction->is_excluded_from_calculation;
        $transaction->save();
    }
}
