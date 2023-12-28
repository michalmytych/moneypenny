<?php

namespace App\Http\Controllers\Web\Synchronization;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Transaction\Synchronization\SynchronizationService;

class SynchronizationController extends Controller
{
    public function __construct(private readonly SynchronizationService $synchronizationService)
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $synchronizations = $this->synchronizationService->all($user);

        return view('synchronizations.index', compact('synchronizations'));
    }
}
