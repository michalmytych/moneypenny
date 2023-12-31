<?php

namespace App\Shared\Providers;

use App\Moneypenny\Import\Contracts\ImportServiceContract;
use App\Moneypenny\Import\Services\ImportService;
use App\Moneypenny\Transaction\Contracts\TransactionSyncServiceInterface;
use App\Nordigen\Services\NordigenService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImportServiceContract::class, ImportService::class);
        $this->app->bind(TransactionSyncServiceInterface::class, NordigenService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
