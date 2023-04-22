<?php

namespace App\Http\Controllers\ExchangeRates;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\Services\ExchangeRates\ExchangeRatesServiceInterface;

class ExchangeRateController extends Controller
{
    public function __construct(private readonly ExchangeRatesServiceInterface $exchangeRatesService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        // @todo
        $date = $request->get('rate_source_date');

        $exchangeRate = $this->exchangeRatesService->getOrCreateExchangeRate(
            date: Carbon::parse($date),
            baseCurrencyCode: 'EUR',
            targetCurrencyCode: 'GBP'
        );

        return response()->json($exchangeRate);
    }
}
