<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\Transaction\TransactionService;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionService $transactionService) {}

    public function index(Request $request): View
    {
        $filter = Filter::makeFromRequest($request);
        $indexData = $this->transactionService->getIndexData($filter);

        return view('transaction.index', $indexData);
    }

    public function show(int $id): View
    {
        $transaction = $this->transactionService->findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }

    public function create(Request $request)
    {
        // @todo
        dd($request->all());
    }
}
