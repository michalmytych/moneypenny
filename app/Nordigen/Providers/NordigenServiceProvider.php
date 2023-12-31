<?php

namespace App\Nordigen\Providers;

use App\Nordigen\Services\NordigenClient;
use App\Nordigen\Services\NordigenClientInterface;
use App\Nordigen\Services\NordigenTransactionServiceInterface;
use App\Transaction\Transaction\TransactionSyncService;
use Illuminate\Support\ServiceProvider;

class NordigenServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NordigenClientInterface::class, function ($app) {
            return new NordigenClient([
                'base_uri' => $app->config->get('nordigen.base_uri'),
                'headers'  => $app->config->get('nordigen.headers'),
            ]);
        });

        $this->app->bind(NordigenTransactionServiceInterface::class, TransactionSyncService::class);
    }
}
