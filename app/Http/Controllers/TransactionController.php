<?php

namespace App\Http\Controllers;

use App\Filters\Filter;
use App\Http\Requests\Web\Transaction\CreateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\Transaction\TransactionService;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionService $transactionService) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $filter = Filter::makeFromRequest($request);
        $indexData = $this->transactionService->getIndexData($filter, $user);

        return view('transaction.index', $indexData);
    }

    public function show(int $id, Request $request): View
    {
        $user = $request->user();
        $transaction = $this->transactionService->findOrFail($id, $user);
        return view('transaction.show', compact('transaction'));
    }

    public function create(CreateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $this->transactionService->create($user, $data);
        return redirect()->to(route('transaction.index'));
    }
}
