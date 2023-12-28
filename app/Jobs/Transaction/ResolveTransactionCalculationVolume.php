<?php

namespace App\Jobs\Transaction;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\ExchangeRates\ExchangeRatesService;
use App\Services\Transaction\Currency\CurrencyService;
use Illuminate\Support\Facades\Log;

class ResolveTransactionCalculationVolume implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public mixed $transactionId)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function handle(CurrencyService $currencyService, ExchangeRatesService $exchangeRatesService): void
    {
        $transaction = Transaction::findOrFail($this->transactionId);

        $currency = $currencyService->resolveCalculationCurrency(user: $transaction->user);
        $baseUserCurrency = Str::upper($currency);
        $transactionCurrency = Str::upper($transaction->currency);
        $transactionDate = Carbon::parse($transaction->transaction_date);

        if ($transactionCurrency !== $baseUserCurrency) {
            try {
                $exchangeRate = $exchangeRatesService->getOrCreateExchangeRate(
                    date: $transactionDate,
                    baseCurrencyCode: $transactionCurrency,
                    targetCurrencyCode: $baseUserCurrency
                );

                $oldCalculationVolume = $transaction->calculation_volume;

                $transaction->update(
                    [
                    'calculation_volume' => $oldCalculationVolume * (float) $exchangeRate->rate
                    ]
                );

            } catch (Throwable $throwable) {
                Log::error($throwable);
            }
        }
    }
}
