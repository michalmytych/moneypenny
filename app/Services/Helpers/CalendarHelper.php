<?php

namespace App\Services\Helpers;

use Illuminate\Support\Carbon;

class CalendarHelper
{
    public static function getMonthDates(?Carbon $carbon = null): array
    {
        $dates = [];

        if (!$carbon) {
            $carbon = Carbon::now();
        }

        $daysInMonth = $carbon->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $carbon->setDay($day)->format('d-m-Y');
            $dates[] = $date;
        }

        return $dates;
    }

    public static function getWeekDates(Carbon $date): array
    {
        $weekDates = [];
        $startOfWeek = $date->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $weekDates[] = $startOfWeek->copy();
            $startOfWeek->addDay();
        }

        return $weekDates;
    }
}
