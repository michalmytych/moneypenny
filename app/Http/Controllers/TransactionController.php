<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Transaction\Transaction;

class TransactionController extends Controller
{
    public function index(): View
    {
        // @todo move caching to trait
        $key = 'latest_transactions';
        if (Cache::has($key)) {
            $transactions = Cache::get($key);
        } else {
            $transactions = Transaction::orderBy('transaction_date', 'desc')->limit(1000)->get();
            Cache::set($key, $transactions);
        }

        return view('transaction.index', compact('transactions'));
    }

    public function show(int $id): View
    {
        $transaction = Transaction::findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }
}
