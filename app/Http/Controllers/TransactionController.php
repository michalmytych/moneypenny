<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Transaction\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $filter = Filter::makeFromRequest($request);

        $transactions = Transaction::applyFilter($filter)
            ->orderBy('transaction_date', 'desc')
            ->limit(1000)
            ->get();

        $filterableColumns = Transaction::getFilterableColumns();

        return view('transaction.index', compact('transactions', 'filterableColumns'));
    }

    public function show(int $id): View
    {
        $transaction = Transaction::findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }
}
