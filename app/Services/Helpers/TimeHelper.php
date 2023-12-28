<?php

namespace App\Services\Helpers;

class TimeHelper
{
    /**
     * Returns rough (in largest single unit) time elapsed between two times.
     *
     * @param  int $iTime0 Initial time, as time_t.
     * @param  int $iTime1 Final time, as time_t. 0=use current time.
     * @return string Time elapsed, like "5 minutes" or "3 days" or "1 month".
     *              You might print "ago" after this return if $iTime1 is now.
     * @author Dan Kamins - dos at axonchisel dot net
     */
    static function ax_getRoughTimeElapsedAsText(int $iTime0, int $iTime1 = 0): string
    {
        if ($iTime1 == 0) { $iTime1 = time(); 
        }
        $iTimeElapsed = $iTime1 - $iTime0;

        if ($iTimeElapsed < (60)) {
            $iNum = $iTimeElapsed;
            $sUnit = "second";
        } else if ($iTimeElapsed < (60*60)) {
            $iNum = intval($iTimeElapsed / 60);
            $sUnit = "minute";
        } else if ($iTimeElapsed < (24*60*60)) {
            $iNum = intval($iTimeElapsed / (60*60));
            $sUnit = "hour";
        } else if ($iTimeElapsed < (30*24*60*60)) {
            $iNum = intval($iTimeElapsed / (24*60*60));
            $sUnit = "day";
        } else if ($iTimeElapsed < (365*24*60*60)) {
            $iNum = intval($iTimeElapsed / (30*24*60*60));
            $sUnit = "month";
        } else {
            $iNum = intval($iTimeElapsed / (365*24*60*60));
            $sUnit = "year";
        }

        return $iNum . " " . $sUnit . (($iNum != 1) ? "s" : "");
    }
}
