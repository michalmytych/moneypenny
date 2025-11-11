<?php

namespace App\Services\Transaction\Categorize;

use App\Models\Transaction\Category;
use App\Models\Transaction\Transaction;
use App\Services\Logging\LoggingAdapterInterface;
use Illuminate\Support\Facades\Http;
use Throwable;

// @todo refactor
readonly class CategoryReferenceService
{
    public function __construct(private LoggingAdapterInterface $loggingAdapter) {}

    public function saveReference(Transaction $transaction): ?int
    {
        $transactionData = $transaction->toArray();
        $requestUrl = config('egghead.save_reference_uri');

        try {
            $response = Http::withHeaders([
                'x-api-key' => config('egghead.api_token')
            ])->post(
                url: $requestUrl,
                data: [
                    'data' => [
                        'transaction' => $transactionData,
                        // Because category may not be accessible through ->category property
                        'category' => Category::findOrFail($transaction->category_id)->toArray()
                    ],
                    'params' => []
                ]
            );

        } catch (Throwable $throwable) {
            $this->loggingAdapter->debugExtension($throwable);

            return null;
        }

        return $response->status();
    }
}
