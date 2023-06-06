<?php

namespace App\Providers;

use App\Contracts\Services\Analysis\AnalysisServiceContract;
use App\Contracts\Services\Import\ImportServiceContract;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;
use App\Services\Analytics\AnalysisService;
use App\Services\Import\ImportService;
use App\Services\Nordigen\NordigenService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImportServiceContract::class, ImportService::class);
        $this->app->bind(AnalysisServiceContract::class, AnalysisService::class);
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
