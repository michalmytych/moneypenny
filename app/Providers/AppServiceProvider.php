<?php

namespace App\Providers;

use App\Services\Import\ImportService;
use Illuminate\Support\ServiceProvider;
use App\Services\Nordigen\NordigenService;
use App\Contracts\Services\Import\ImportServiceContract;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

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
