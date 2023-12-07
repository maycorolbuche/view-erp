<?php

namespace App\Helpers;

use App\Models\DiscountAmount;

class DiscountHelper
{
    public static function amount($id_discount, $date)
    {
        $ref_date = DiscountAmount::where('id_discount', $id_discount)
            ->where('date', '<=', $date)
            ->max('date');

        if (!$ref_date) {
            return 0;
        }

        $amount = DiscountAmount::where('id_discount', $id_discount)
            ->where('date', $ref_date)
            ->max('amount');

        return +$amount;
    }
}
