<?php

namespace App\Helpers;

use App\Helpers\HolidayHelper;

class DateTimeHelper
{
    public static function distribute($amount, $start_date, $days, $end_date, $id_branch)
    {
        $date = new \DateTime($start_date);
        $max_date = new \DateTime($end_date);

        $partial_amount = round($amount / $days, 2);

        $last_item = "";

        $items = [];
        for ($i = 0; $i < $days; $i++) {
            $d = clone $date;
            $date->modify('+1 day');

            //Verifica se é maior que a data limite
            if ($d > $max_date) {
                break;
            }

            //Verifica se é fim de semana
            $week = (int)$d->format('w');
            if ($week == 0 || $week == 6) {
                $days++;
                continue;
            }

            //Verifica se é feriado
            $holidays = HolidayHelper::date($d->format('Y-m-d'), $id_branch);
            if (count($holidays) > 0) {
                $days++;
                continue;
            }

            $items[$d->format('Y-m-d')] = $partial_amount;
            $last_item = $d->format('Y-m-d');
        }

        if ($last_item <> "") {
            $last = $amount - ($partial_amount * (count($items) - 1));
            $items[$last_item] = $last;
        }

        return $items;
    }
}
