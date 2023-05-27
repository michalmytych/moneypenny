<?php

namespace App\Jobs\Transaction;

use App\Models\Transaction\Category;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use hisorange\BrowserDetect\Exceptions\Exception;

class CategorizeTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public array $transactionsIds)
    {
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(): void
    {
        $transactions = Transaction::whereIn('id', $this->transactionsIds)->get();

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

        Log::debug($response->reason());

        $categorizedData = $response->json();

        foreach ($categorizedData ?? [] as $record) {
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
        }
    }
}
