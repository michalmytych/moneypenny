<?php

namespace App\Shared\Providers;

use App\Moneypenny\Import\Models\Import;
use App\Moneypenny\Import\Observers\ImportObserver;
use App\Moneypenny\Synchronization\Models\Synchronization;
use App\Moneypenny\Synchronization\Observers\SynchronizationObserver;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\Transaction\Observers\TransactionObserver;
use App\Moneypenny\User\Models\User;
use App\Moneypenny\User\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Import::observe(ImportObserver::class);
        Transaction::observe(TransactionObserver::class);
        Synchronization::observe(SynchronizationObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
