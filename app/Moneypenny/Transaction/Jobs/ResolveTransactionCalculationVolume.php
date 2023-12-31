<?php

namespace App\Moneypenny\Transaction\Jobs;

use App\ExchangeRates\Services\ExchangeRatesService;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Transaction\Currency\CurrencyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ResolveTransactionCalculationVolume implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public mixed $transactionId) {}

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

                $transaction->update([
                    'calculation_volume' => $oldCalculationVolume * (float) $exchangeRate->rate
                ]);

            } catch (Throwable $throwable) {
                Log::error($throwable);
            }
        }
    }
}
