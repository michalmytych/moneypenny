<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\HomePage\HomePageService;
use App\Services\Transaction\PersonalAccount\SaldoService;

class HomeController extends Controller
{
    public function __construct(
        private readonly SaldoService $saldoService,
        private readonly HomePageService $homePageService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $saldoData = $this->saldoService->getByUser($user);
        $transactionsData = $this->homePageService->getLatestTransactionsData($user);
        return view('home.index', compact('transactionsData', 'saldoData'));
    }
}
