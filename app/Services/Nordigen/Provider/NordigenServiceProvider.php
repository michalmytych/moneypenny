<?php

namespace App\Services\Nordigen\Provider;

use App\Services\Nordigen\NordigenClient;
use App\Services\Nordigen\NordigenClientInterface;
use App\Services\Nordigen\Synchronization\NordigenTransactionServiceInterface;
use App\Services\Transaction\TransactionSyncService;
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
