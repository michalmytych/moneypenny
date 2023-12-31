<?php

namespace App\Moneypenny\Categorize\Http\Controller\Web;

use App\Moneypenny\Transaction\Jobs\RecategorizeAllTransactions;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Shared\Http\Controller\Controller;
use App\Transaction\Categorize\CategorizationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategorizationController extends Controller
{
    public function __construct(
        private readonly CacheAdapterInterface $cacheAdapter,
        private readonly CategorizationService $categorizationService
    ) {}

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
        $this->cacheAdapter->set(CategorizationService::PENDING_CATEGORIZATION_CACHE_KEY, 1, 2 * 60);

        return to_route('categorization.index');
    }
}
