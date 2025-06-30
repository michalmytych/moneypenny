<?php

namespace App\Jobs\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Transaction\Settings\UserSettingsService;

/** @deprecated - user settings should be created in sync flow */
class CreateUserSettings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(UserSettingsService $userSettingsService): void
    {
        $userSettingsService->assureUserSettings($this->user);
    }
}
