<?php

namespace App\ExchangeRates\Providers;

use App\ExchangeRates\Contracts\ExchangeRatesServiceInterface;
use App\ExchangeRates\Services\ExchangeRatesClient;
use App\ExchangeRates\Services\ExchangeRatesService;
use Illuminate\Support\ServiceProvider;

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

        $this->app->bind(ExchangeRatesServiceInterface::class, ExchangeRatesService::class);
    }
}
