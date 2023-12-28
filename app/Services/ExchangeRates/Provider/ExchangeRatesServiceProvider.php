<?php

namespace App\Services\ExchangeRates\Provider;

use App\Contracts\Services\ExchangeRates\ExchangeRatesServiceInterface;
use App\Services\ExchangeRates\ExchangeRatesClient;
use App\Services\ExchangeRates\ExchangeRatesService;
use Illuminate\Support\ServiceProvider;

class ExchangeRatesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ExchangeRatesClient::class, function ($app) {
                return new ExchangeRatesClient(
                    [
                    'base_uri' => $app->config->get('exchange_rates.base_uri'),
                    'headers'  => [
                    'apikey' => $app->config->get('exchange_rates.api_key'),
                    'Accept' => 'application/json',
                    ],
                    ]
                );
            }
        );

        $this->app->bind(ExchangeRatesServiceInterface::class, ExchangeRatesService::class);
    }
}
