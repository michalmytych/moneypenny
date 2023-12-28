<?php

namespace App\Http\Controllers\Web\Transaction;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Transaction\PersonalAccount;

class PersonalAccountController extends Controller
{
    public function index(Request $request): View
    {
        $personalAccounts = PersonalAccount::whereUser($request->user())
            ->latest()
            ->withCount('transactions')
            ->get();

        return view(
            'personal_account.index', [
            'personalAccounts' => $personalAccounts
            ]
        );
    }

    public function edit(Request $request): View
    {
        // @todo - handle editing multiplte personal account saldos
        $personalAccount = $request->user()->personalAccounts()->first();

        return view(
            'personal_account.edit', [
            'personalAccount' => $personalAccount
            ]
        );
    }

    public function update(Request $request): RedirectResponse
    {
        // @todo - handle editing multiplte personal account saldos
        $personalAccount = $request->user()->personalAccounts()->first();
        $request->validate(
            [
            'value' => 'numeric|gte:0'
            ]
        );
        $personalAccount->update(
            [
            'value' => $request->input('value')
            ]
        );

        return to_route('home');
    }
}
