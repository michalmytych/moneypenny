<?php

namespace App\Http\Controllers\Web\Transaction;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PersonalAccountController extends Controller
{
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
        return redirect()->to(route('home'));
    }
}
