<?php

namespace App\Http\Controllers\Web\Transaction\Categorize;

use App\Http\Controllers\Controller;
use App\Jobs\Transaction\RecategorizeAllTransactions;
use App\Services\Transaction\Categorize\CategorizationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategorizationController extends Controller
{
    public function __construct(private readonly CategorizationService $categorizationService) {}

    public function index(): View
    {
        $recategorizationsIsRunning = $this->categorizationService->getRecategorizationsPending();
        $uncategorizedTransactions = $this->categorizationService->getUncategorizedTransactions();
        $stats = $this->categorizationService->getStats();

        return view(
            'categorization.index',
            compact('stats', 'recategorizationsIsRunning', 'uncategorizedTransactions')
        );
    }

    public function trigger(): RedirectResponse
    {
        RecategorizeAllTransactions::dispatch();
        Cache::set(CategorizationService::PENDING_CATEGORIZATION_CACHE_KEY, 1, 2 * 60);

        return redirect(route('categorization.index'));
    }
}
