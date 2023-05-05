<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\HomePage\HomePageService;

class HomeController extends Controller
{
    public function __construct(private readonly HomePageService $homePageService)
    {
    }

    public function index(): View
    {
        $transactionsData = $this->homePageService->getLatestTransactionsData();
        return view('home.index', compact('transactionsData'));
    }
}
