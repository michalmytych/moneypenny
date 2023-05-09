<?php

namespace App\Http\Controllers\ExchangeRates;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\ExchangeRates\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index(): View
    {
        $exchangeRates = ExchangeRate::latest()->get();
        return view('exchange_rates.index', compact('exchangeRates'));
    }
}
