<?php

namespace App\Services\Transaction\Categorize;

use App\Models\Transaction\Category;
use App\Models\Transaction\Transaction;
use App\Services\Logging\LaravelLoggingAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\LazyCollection;

readonly class TransactionCategorizeService
{
    public function __construct(private LaravelLoggingAdapter $loggingAdapter) {}

    public function categorizeTransactions(Collection|LazyCollection|array $transactions): float|int
    {
        $postData = [];
        foreach ($transactions as $transaction) {
            /** @var Transaction $transaction */
            $postData[] = [
                'id' => $transaction->id,
                'currency_id' => $transaction->currency,
                'import_id' => $transaction->import_id,
                'description' => $transaction->description,
                'receiver' => $transaction->receiver,
                'sender' => $transaction->sender,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
                'volume' => null,
                'type' => null,
                'execution_datetime' => $transaction->transaction_date,
                'volume_relative_value' => $transaction->calculation_volume
            ];
        }

        $requestUrl = config('egghead.base_api_url');

        // @todo refactor
        $response = Http::withHeaders([
            'x-api-key' => config('egghead.api_token')
        ])->post(
            url: $requestUrl,
            data: $postData
        );

        $this->loggingAdapter->debug($response->reason());

        $categorizedData = $response->json() ?? [];

        $categorizedTransactionsCount = 0;
        foreach ($categorizedData as $record) {
            // @todo int ?? should be mixed
            $transactionId = (int) data_get($record, 'id');
            $categoryCode = (string) data_get($record, 'category');

            if ($categoryCode === '') {
                continue;
            }

            $transaction = Transaction::find($transactionId);
            if (!$transaction) {
                continue;
            }

            $categories = explode('-', $categoryCode);
            $rootCategoryCode = $categories[0];

            $category = Category::firstOrCreate(['code' => $rootCategoryCode]);
            $transaction->update(['category_id' => $category->id]);

            ++$categorizedTransactionsCount;
        }

        return count($categorizedData) !== 0 ? $categorizedTransactionsCount / count($categorizedData) : 0;
    }
}
