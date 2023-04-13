<?php

namespace App\ExchangeRates\Provider;

use Illuminate\Support\ServiceProvider;
use App\ExchangeRates\ExchangeRatesClient;
use App\Services\Transaction\TransactionSyncService;
use App\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class ExchangeRatesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ExchangeRatesClient::class, function ($app) {
            return new ExchangeRatesClient([
                'base_uri' => $app->config->get('exchange_rates.base_uri'),
                'headers'  => [
                    'apikey' => $app->config->get('exchange_rates.api_key'),
                    'Accept' => 'application/json',
                ],
            ]);
        });

        $this->app->bind(NordigenTransactionServiceInterface::class, TransactionSyncService::class);
    }
}
