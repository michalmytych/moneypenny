<?php

namespace App\Http\Controllers\Web\Synchronization;

use App\Http\Controllers\Controller;
use App\Transaction\Synchronization\SynchronizationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SynchronizationController extends Controller
{
    public function __construct(private readonly SynchronizationService $synchronizationService) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $synchronizations = $this->synchronizationService->all($user);

        return view('synchronizations.index', compact('synchronizations'));
    }
}
