<?php

namespace App\Nordigen\Provider;

use App\Nordigen\NordigenClient;
use Illuminate\Support\ServiceProvider;
use App\Services\Transaction\TransactionSyncService;
use App\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class NordigenServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NordigenClient::class, function ($app) {
            return new NordigenClient([
                'base_uri' => $app->config->get('nordigen.base_uri'),
                'headers'  => $app->config->get('nordigen.headers'),
            ]);
        });

        $this->app->bind(NordigenTransactionServiceInterface::class, TransactionSyncService::class);
    }
}
