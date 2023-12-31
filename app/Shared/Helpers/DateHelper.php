<?php

namespace App\Shared\Helpers;

use Illuminate\Support\Carbon;

class DateHelper
{
    public static function getLastMonthDates(): array
    {
        $dates = [];

        // @todo should return all dates from now to sub month not all dates in last month
        $lastMonth = Carbon::now()->subMonth();
        $daysInLastMonth = $lastMonth->daysInMonth;

        for ($day = 1; $day <= $daysInLastMonth; $day++) {
            $date = $lastMonth->setDay($day)->format('d-m-Y');
            $dates[] = $date;
        }

        return $dates;
    }
}
