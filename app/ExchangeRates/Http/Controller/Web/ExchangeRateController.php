<?php

namespace App\ExchangeRates\Http\Controller\Web;

use App\ExchangeRates\Services\ExchangeRatesService;
use App\Shared\Http\Controller\Controller;
use Illuminate\View\View;

class ExchangeRateController extends Controller
{
    public function __construct(private readonly ExchangeRatesService $exchangeRatesService) {}

    public function index(): View
    {
        $exchangeRates = $this->exchangeRatesService->all();

        return view('exchange_rates.index', compact('exchangeRates'));
    }
}
