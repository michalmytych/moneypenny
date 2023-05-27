<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\EditSettingsRequest;
use App\Models\Auth\Settings;
use App\Services\Notification\Broadcast\NotificationBroadcastService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(private readonly NotificationBroadcastService $notificationBroadcastService) {}

    public function edit(Request $request): View
    {
        $settings = Settings::query()
            ->where(['user_id' => $request->user()->id])
            ->get()
            ->first();

        return view('settings.edit', compact('settings'));
    }

    public function update(EditSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        Settings::firstOrCreate([
            'user_id' => $user->id,
            'base_currency_code' => $data['base_currency_code']
        ]);

        $this->notificationBroadcastService->sendStoredApplicationNotification(
            header: 'Settings saved',
            content: 'Now moneypenny will adjust to your settings',
            url: route('setting.edit')
        );

        return redirect()->to(route('home'));
    }
}
