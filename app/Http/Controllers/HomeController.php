<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Nordigen\EndUserAgreement;
use App\Services\HomePage\HomePageService;
use App\Models\Synchronization\Synchronization;
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

        return view(
            'home.index',
            [
                'transactionsData' => $this->homePageService->getLatestTransactionsData($user),
                'saldoData' => $this->saldoService->getByUser($user),
                'synchronizationsCount' => Synchronization::count(), // @todo
                'endUserAgreementCount' => EndUserAgreement::count() // @todo
            ]
        );
    }
}
