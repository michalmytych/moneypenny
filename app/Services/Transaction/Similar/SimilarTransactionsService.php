<?php

namespace App\Services\Transaction\Similar;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Models\Transaction\Transaction;

class SimilarTransactionsService
{
    public function getSimilarTransactions(Transaction $transaction): Collection
    {
        $searchTokens = $this->getSearchTokens($transaction);
        $baseQuery = $this->getBaseTransactionQuery($transaction);

        $baseQueryClone = clone $baseQuery;

        /** @var Collection $baseQueryResult */
        $baseQueryResult = $baseQueryClone->get();

        if ($baseQueryResult->count() < 5) {
            foreach ($searchTokens as $token) {
                $this->improveSearchQueryWithToken($transaction, $baseQueryClone, $token);
            }

            return $baseQueryResult
                ->concat($baseQueryClone->get())
                ->unique('id');
        } else {
            return $baseQueryResult;
        }
    }

    private function getSearchTokens(Transaction $transaction): array
    {
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

        $search = array_filter($search, fn($s) => strlen($s) > 3);
        usort($search, fn($a, $b) => strlen($b) - strlen($a));

        return array_slice($search, 0, 10, true);
    }

    private function getBaseTransactionQuery(Transaction $transaction): Builder
    {
        return Transaction::whereUser($transaction->user)
            ->baseCalculationQuery()
            ->whereNot('id', $transaction->id)
            ->where('description', 'like', '%' . $transaction->description . '%')
            ->where('receiver', 'like', '%' . $transaction->receiver . '%')
            ->where('sender', 'like', '%' . $transaction->sender . '%')
            ->limit(20);
    }

    private function improveSearchQueryWithToken(Transaction $transaction, Builder $baseQueryClone, string $token): void
    {
        $onlyLettersToken = preg_replace('/[^A-Za-z\-]/', '', $token);

        $baseQueryClone
            ->orWhereRaw('UPPER(description) LIKE ?', ['%' . $onlyLettersToken . '%'])
            ->when($transaction->category, fn(Builder $builder) => $builder
                ->orWhere('category_id', $transaction->category?->id)
            );
    }
}
