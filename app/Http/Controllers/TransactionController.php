<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Transaction\Transaction;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::orderBy('transaction_date', 'desc')->get();
        return view('transaction.index', compact('transactions'));
    }
}
