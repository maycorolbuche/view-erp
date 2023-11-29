<?php

namespace App\Helpers;

use App\Models\Holiday;

class HolidayHelper
{
    public static function date($date, $id_branch)
    {
        $d = new \DateTime($date);

        $year = $d->format('Y');
        $month = $d->format('m');
        $day = $d->format('d');

        $easter_date = new \DateTime(date('Y-m-d', easter_date($year)));

        $easter = $d->diff($easter_date)->days;
        if ($d < $easter_date) {
            $easter = $easter * -1;
        }

        $holiday = Holiday::select('name')
            ->where(function ($query) use ($id_branch) {
                $query->whereHas('holidays_branches', function ($query) use ($id_branch) {
                    $query->where('holidays_branches.id_branch', $id_branch);
                })->orWhereDoesntHave('holidays_branches');
            })
            ->where(function ($query) use ($year) {
                $query->whereNull('year')->orWhere('year', $year);
            })
            ->where(function ($query) use ($month) {
                $query->whereNull('month')->orWhere('month', $month);
            })
            ->where(function ($query) use ($day) {
                $query->whereNull('day')->orWhere('day', $day);
            })
            ->where(function ($query) use ($easter) {
                $query->whereNull('easter')->orWhere('easter', $easter);
            })
            ->pluck('name')
            ->toArray();

        return $holiday;
    }
}
