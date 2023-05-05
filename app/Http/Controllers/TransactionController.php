<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Models\Transaction\Persona;
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
        $personas = Persona::orderBy('common_name')->get();

        return view('transaction.index', compact('transactions', 'filterableColumns', 'personas'));
    }

    public function show(int $id): View
    {
        $transaction = Transaction::findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }

    public function create(Request $request)
    {
        dd($request->all());
    }
}
