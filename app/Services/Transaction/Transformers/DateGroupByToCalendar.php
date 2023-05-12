<?php

namespace App\Services\Transaction\Transformers;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DateGroupByToCalendar extends Transformer
{
    public static function transform(mixed $data, string $dateKey, string $valueKey): Collection
    {
        /** @var Collection $data */
        $datesData = $data->toArray();
        $result = collect();

        $sinceDate = $datesData[0][$dateKey];
        $toDate = end($datesData)[$dateKey];

        $period = CarbonPeriod::create($sinceDate, $toDate);

        foreach ($period as $date) {
            $valueData = 0.0;
            $currentDate = data_get($datesData, 0);

            $dayString = $date->format('Y-m-d');
            $dayFromDaya = Carbon::parse($currentDate[$dateKey])->format('Y-m-d');

            if ($dayFromDaya === $dayString) {
                $valueData = floatval($currentDate[$valueKey]);
                array_shift($datesData);
            }

            $result->push([
                'date' => $dayString,
                'total' => $valueData
            ]);
        }

        return $result;
    }
}
