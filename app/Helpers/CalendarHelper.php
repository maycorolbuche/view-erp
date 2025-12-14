<?php

namespace App\Helpers;

use DateTime;
use App\Helpers\HolidayHelper;

class CalendarHelper
{
    public static function addBusinessDays(DateTime $date, int $business_days, ?int $id_branch = null): DateTime
    {
        $date = clone $date;

        for ($i = 0; $i < $business_days; $i++) {
            $date->modify('+1 day');

            while (in_array((int)$date->format('N'), [6, 7])) {
                $date->modify('+1 day');
            }

            while (HolidayHelper::date($date, $id_branch)) {
                $date->modify('+1 day');
            }
        }

        return $date;
    }
}
