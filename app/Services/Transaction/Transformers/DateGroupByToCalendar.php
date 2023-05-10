<?php

namespace App\Services\Transaction\Transformers;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class DateGroupByToCalendar extends Transformer
{
    public static function transform(mixed $data): Collection
    {
        /** @var Collection $data */
        $datesData = $data->toArray();
        $result = collect();

        $sinceDate = $datesData[0]['date'];
        $toDate = end($datesData)['date'];

        $period = CarbonPeriod::create($sinceDate, $toDate);

        foreach ($period as $date) {
            $sumData = 0.0;
            $currentDate = data_get($datesData, 0);

            $dayString = $date->format('Y-m-d');
            if ($currentDate['date'] === $dayString) {
                $sumData = floatval($currentDate['total']);
                array_shift($datesData);
            }

            $result->push([
                'date' => $dayString,
                'total' => $sumData
            ]);
        }

        return $result;
    }
}
