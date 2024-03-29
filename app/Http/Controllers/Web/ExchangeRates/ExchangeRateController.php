<?php

namespace App\Http\Controllers\Web\ExchangeRates;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Services\ExchangeRates\ExchangeRatesService;

class ExchangeRateController extends Controller
{
    public function __construct(private readonly ExchangeRatesService $exchangeRatesService) {}

    public function index(): View
    {
        $exchangeRates = $this->exchangeRatesService->all();

        return view('exchange_rates.index', compact('exchangeRates'));
    }
}
