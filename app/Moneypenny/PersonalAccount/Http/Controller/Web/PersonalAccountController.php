<?php

namespace App\Moneypenny\PersonalAccount\Http\Controller\Web;

use App\Moneypenny\PersonalAccount\Models\PersonalAccount;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Shared\Http\Controller\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonalAccountController extends Controller
{
    public function __construct(private readonly CacheAdapterInterface $cacheAdapter)
    {
    }

    public function index(Request $request): View
    {
        $personalAccounts = PersonalAccount::whereUser($request->user())
            ->latest()
            ->withCount('transactions')
            ->get();

        return view('personal_account.index', [
            'personalAccounts' => $personalAccounts
        ]);
    }

    public function edit(Request $request): View
    {
        // @todo - handle editing multiplte personal account saldos
        $personalAccount = $request->user()->personalAccounts()->first();

        return view('personal_account.edit', [
            'personalAccount' => $personalAccount
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        // @todo - handle editing multiplte personal account saldos
        $personalAccount = $request->user()->personalAccounts()->first();

        $request->validate([
            'value' => 'numeric|gte:0'
        ]);

        $personalAccount->update([
            'value' => $request->input('value')
        ]);

        $this->cacheAdapter->clearUserCache($request->user());

        return to_route('home');
    }
}
