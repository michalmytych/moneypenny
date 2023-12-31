<?php

namespace App\Moneypenny\Synchronization\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
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
