<?php

namespace App\Services\Transaction\Categorize;

use App\Models\Transaction\Category;
use App\Models\Transaction\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

// @todo refactor
class CategoryReferenceService
{
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
            Log::debug($throwable->getMessage());

            return null;
        }

        return $response->status();
    }
}
