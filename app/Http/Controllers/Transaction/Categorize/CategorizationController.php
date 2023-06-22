<?php

namespace App\Http\Controllers\Transaction\Categorize;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use App\Jobs\Transaction\RecategorizeAllTransactions;
use App\Services\Transaction\Categorize\CategorizationService;

class CategorizationController extends Controller
{
    public function __construct(private readonly CategorizationService $categorizationService) {}

    public function index(): View
    {
        $recategorizationsIsRunning = $this->categorizationService->getRecategorizationsPending();
        $stats = $this->categorizationService->getStats();
        return view('categorization.index', compact('stats', 'recategorizationsIsRunning'));
    }

    public function trigger(): RedirectResponse
    {
        RecategorizeAllTransactions::dispatch();
        Cache::set(CategorizationService::PENDING_CATEGORIZATION_CACHE_KEY, 1, 2 * 60);
        return redirect(route('categorization.index'));
    }
}
