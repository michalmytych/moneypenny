<?php

namespace App\Services\Transaction\Transformers;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DateGroupByToCalendar extends Transformer
{
    public static function transform(mixed $data, string $dateKey, string $valueKey): Collection
    {
        // @todo - refactor
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
            $dayFromData = Carbon::parse($currentDate[$dateKey])->format('Y-m-d');

            if ($dayFromData === $dayString) {
                $valueData = floatval($currentDate[$valueKey]);
                array_shift($datesData);
            }

            // @todo ASAP - rm this hack
            if (!$valueData) {
                $lastResult = $result->last();
                if ($lastResult) {
                    $lastTotal = data_get($lastResult, 'total');
                    $valueData = $lastTotal - 10;
                }
            }

            $result->push([
                'date' => $dayString,
                'total' => $valueData
            ]);
        }

        // @todo ASAP - rm this hack
        return $result->map(function($record, $ix) use ($result) {
            $total = data_get($record, 'total');
            if ($total <= 0) {
                $nextIx = intval($ix) + 3;
                $nextRecord = $result->get($nextIx);
                if ($nextRecord) {
                    $nextTotal = data_get($nextRecord, 'total');
                    $record['total'] = $nextTotal;
                }
            }
            return $record;
        });
    }
}
