<?php

namespace App\Services\Transaction;

use App\Models\User;
use App\Filters\Filter;
use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;
use App\Services\Helpers\TransactionHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TransactionService
{
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

        /** @var Transaction $transaction */
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
        // @todo - improve search, refactor, optimize
        if (!$transaction) {
            return collect();
        }

        $search = $transaction->description
            . ' ' . $transaction->receiver
            . ' ' . $transaction->sender;

        $separators = ['-', '.', ',', '/', '\\', '--', '(', ')'];
        $search = str_replace(
            $separators,
            ' ',
            $search
        );

        $search = explode(' ', $search);

        // Sort by length
        $search = array_filter($search, fn($s) => strlen($s) > 3);
        usort($search, fn($a, $b) => strlen($b) - strlen($a));

        // Get max 10 longest
        $tokens = array_slice($search, 0, 10, true);

        $baseQuery = Transaction::whereUser($transaction->user)
            ->where('id', '!=', $transaction->id)
            ->where('description', 'like', '%' . $transaction->description . '%')
            ->where('receiver', 'like', '%' . $transaction->receiver . '%')
            ->where('sender', 'like', '%' . $transaction->sender . '%')
            ->limit(20);

        $baseQueryClone = clone $baseQuery;

        /** @var Collection $result */
        $result = $baseQueryClone->get();

        if ($result->count() < 5) {
            foreach ($tokens as $token) {
                $onlyLettersToken = preg_replace('/[^A-Za-z\-]/', '', $token);

                $baseQueryClone
                    ->orWhereRaw('UPPER(description) LIKE ?', ['%' . $onlyLettersToken . '%'])
                    ->when($transaction->category, fn(Builder $builder) => $builder
                        ->orWhere('category_id', $transaction->category?->id)
                    );
            }

            return $result
                ->concat($baseQueryClone->get())
                ->unique('id');
        } else {
            return $result;
        }
    }
}
