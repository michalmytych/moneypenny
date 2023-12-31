<?php

namespace App\ExchangeRates\Services;

use App\ExchangeRates\Contracts\ExchangeRatesServiceInterface;
use App\ExchangeRates\DataObjects\HistoricalExchangeRateDataObject;
use App\ExchangeRates\Models\ExchangeRate;
use App\Shared\Http\Client\Traits\DecodesHttpJsonResponse;
use App\Shared\Services\Logging\LoggingAdapterInterface;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ExchangeRatesService implements ExchangeRatesServiceInterface
{
    use DecodesHttpJsonResponse;

    public function __construct(
        private readonly LoggingAdapterInterface $loggingAdapter,
        private readonly ExchangeRatesClient     $exchangeRatesClient
    )
    {
    }

    public function all(): Collection
    {
        return ExchangeRate::latest()->get();
    }

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
                'rate' => $dataObject->rate,
                'base_currency' => $dataObject->baseCurrencyCode,
                'target_currency' => $dataObject->targetCurrencyCode,
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
                'base' => $baseCurrencyCode,
                'symbols' => $targetCurrencyCode,
            ],
        ]);

        $responseData = $this->decodedResponse($response);

        if (!data_get($responseData, 'success')) {
            $this->loggingAdapter->debug(json_encode($responseData));
            throw new Exception('Invalid data received from Exchange Rates API');
        }

        $rateDataObjectData = [
            'date' => Carbon::parse($responseData['date']),
            'base_currency_code' => $responseData['base'],
            'target_currency_code' => $targetCurrencyCode,
            'rate' => data_get($responseData, "rates.$targetCurrencyCode"),
        ];

        return HistoricalExchangeRateDataObject::make($rateDataObjectData);
    }
}