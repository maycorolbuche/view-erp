<?php

namespace App\Helpers;

use App\Models\Batch;
use Illuminate\Support\Facades\Auth;

class BatchHelper
{
    public static function data($id)
    {
        $data = Batch::with([
            'user.users_cash',
            'categories' => function ($query) {
                $query->orderBy('short_name');
            },
            'clients' => function ($query) {
                $query->orderBy('short_name');
            },
            'expenses' => function ($query) {
                $query->orderBy('date');
            },
            'discounts'
        ])->find($id);
        if ($data) {
            $chart_categories = $data->categories->map(function ($category) {
                return [
                    'name' => $category['short_name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            $chart_clients = $data->clients->map(function ($category) {
                return [
                    'name' => $category['short_name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            return compact('data', 'chart_categories', 'chart_clients');
        } else {
            return null;
        }
    }
}
