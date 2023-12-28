<?php

namespace App\Console\Commands\ExchangeRates;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\Transaction\Transaction;
use App\Contracts\Services\ExchangeRates\ExchangeRatesServiceInterface;

class PullExchangeRates extends Command
{
    protected $signature = 'moneypenny:pull-exchange-rates';

    protected $description = 'Fetch history exchange rates from external api for currently stored transactions';

    public function handle(ExchangeRatesServiceInterface $exchangeRatesService): void
    {
        $defaultCurrency = config('moneypenny.base_calculation_currency');

        $otherCurrenciesTransactionsCursor = Transaction::query()
            ->whereNot('currency', $defaultCurrency)
            ->cursor();

        foreach ($otherCurrenciesTransactionsCursor as $transaction) {
            $exchangeRate = $exchangeRatesService->getOrCreateExchangeRate(
                date: Carbon::parse($transaction->transaction_date),
                baseCurrencyCode: $transaction->currency,
                targetCurrencyCode: $defaultCurrency
            );

            $result = $exchangeRate->rate * $transaction->decimal_volume;

            $line = "Exchanging $transaction->currency to $defaultCurrency: $exchangeRate->rate * $transaction->decimal_volume = $result";
            $this->line($line);

            $transaction->update([
                'calculation_volume' => $exchangeRate->rate * $transaction->decimal_volume
            ]);
        }
    }
}
