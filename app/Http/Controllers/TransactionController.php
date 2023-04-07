<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Transaction\Transaction;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::all();
        return view('transaction.index', compact('transactions'));
    }
}
