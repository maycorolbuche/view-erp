<?php

namespace App\Helpers;

use App\Models\Batch;

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

    public static function close_without_refund()
    {
        $ids = [];

        $batches = Batch::where('created_at', '<', now()->subDays(30))
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
