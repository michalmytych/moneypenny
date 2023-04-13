<?php

namespace App\ExchangeRates;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\ExchangeRates\ExchangeRate;
use App\Http\Client\Traits\DecodesHttpJsonResponse;
use App\ExchangeRates\DataObjects\HistoricalExchangeRateDataObject;
use App\Contracts\Services\ExchangeRates\ExchangeRatesServiceInterface;

class ExchangeRatesService implements ExchangeRatesServiceInterface
{
    use DecodesHttpJsonResponse;

    public function __construct(private ExchangeRatesClient $exchangeRatesClient) { }

    /**
     * @throws GuzzleException
     */
    public function getOrCreateExchangeRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): ExchangeRate
    {
        $exchangeRate = ExchangeRate::query()
            ->whereDate('rate_source_date', $date->format('Y-m-d'))
            ->where('base_currency', $baseCurrencyCode)
            ->where('target_currency', $targetCurrencyCode)
            ->get()
            ->first();

        if (!$exchangeRate) {
            $dataObject = $this->provideNewHistoryRate($date, $baseCurrencyCode, $targetCurrencyCode);
            return ExchangeRate::create([
                'rate'             => $dataObject->rate,
                'base_currency'    => $dataObject->baseCurrencyCode,
                'target_currency'  => $dataObject->targetCurrencyCode,
                'rate_source_date' => $dataObject->date,
            ]);
        }

        return $exchangeRate;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function provideNewHistoryRate(Carbon $date, string $baseCurrencyCode, string $targetCurrencyCode): HistoricalExchangeRateDataObject
    {
        $dateString = $date->format('Y-m-d');

        $response = $this->exchangeRatesClient->get("/exchangerates_data/$dateString", [
            'query' => [
                'base'    => $baseCurrencyCode,
                'symbols' => $targetCurrencyCode,
            ],
        ]);

        $responseData = $this->decodedResponse($response);

        if (!data_get($responseData, 'success')) {
            Log::debug(json_encode($responseData));
            throw new Exception('Invalid data received from Exchange Rates API');
        }

        $rateDataObjectData = [
            'date'                 => Carbon::parse($responseData['date']),
            'base_currency_code'   => $responseData['base'],
            'target_currency_code' => $targetCurrencyCode,
            'rate'                 => data_get($responseData, "rates.$targetCurrencyCode"),
        ];

        return HistoricalExchangeRateDataObject::make($rateDataObjectData);
    }
}
