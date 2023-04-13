<?php

namespace App\ExchangeRates\Provider;

use Illuminate\Support\ServiceProvider;
use App\ExchangeRates\ExchangeRatesClient;
use App\ExchangeRates\ExchangeRatesService;
use App\Contracts\Services\ExchangeRates\ExchangeRatesServiceInterface;

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
