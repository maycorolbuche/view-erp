<?php

namespace App\Helpers;

use App\Models\Batch;
use App\Helpers\ConfigHelper as Configs;

class BatchHelper
{
    public static function data($id)
    {
        $data = Batch::with([
            'user.users_cash',
            'categories' => function ($query) {
                $query->orderBy('short_name')->orderBy('name');
            },
            'clients' => function ($query) {
                $query->orderBy('short_name')->orderBy('name');
            },
            'expenses' => function ($query) {
                $query->orderBy('date');
            },
            'discounts'
        ])->find($id);
        if ($data) {
            $chart_categories = $data->categories->map(function ($category) {
                return [
                    'name' => $category['short_name'] ?? $category['name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            $chart_clients = $data->clients->map(function ($category) {
                return [
                    'name' => $category['short_name'] ?? $category['name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            return compact('data', 'chart_categories', 'chart_clients');
        } else {
            return null;
        }
    }

    public static function close_without_refund()
    {
        $days_to_close = +Configs::get('batches.active.days_to_close_without_refund', 30);

        $ids = [];

        $batches = Batch::where('created_at', '<', now()->subDays($days_to_close))
            ->where('refundable_amount', 0)
            ->where('active', true)->get();
        foreach ($batches as $batch) {
            $batch->active = false;
            $batch->save();

            $ids[] = $batch->id_batch;
        }

        return  'Lotes encerrados: ' . json_encode($ids);
    }
}
