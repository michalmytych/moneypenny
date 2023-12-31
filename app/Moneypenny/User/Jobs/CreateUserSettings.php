<?php

namespace App\Moneypenny\User\Jobs;

use App\Moneypenny\User\Models\User;
use App\Transaction\Settings\UserSettingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateUserSettings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(UserSettingsService $userSettingsService): void
    {
        $userSettingsService->assureUserSettings($this->user);
    }
}
