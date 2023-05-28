<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Filters\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Transaction\CreateRequest;
use App\Http\Requests\Web\Transaction\PatchRequest;
use App\Models\Transaction\Transaction;
use App\Services\Transaction\Currency\CurrencyService;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService,
        private readonly CurrencyService $currencyService
    ) {}

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
        $similarTransactions = $this->transactionService->getSimilarTransactions($transaction);
        $userBaseCurrency = $this->currencyService->resolveCalculationCurrency($user);
        return view('transaction.show', compact('transaction', 'similarTransactions', 'userBaseCurrency'));
    }

    public function create(CreateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $this->transactionService->create($user, $data);
        return redirect()->to(route('transaction.index'));
    }

    public function patch(mixed $transactionId, PatchRequest $request): RedirectResponse
    {
        $transaction = Transaction::findOrFail($transactionId);
        $data = $request->validated();
        $transaction->update($data);
        return redirect()->to(route('transaction.show', ['id' => $transaction->id]));
    }
}
