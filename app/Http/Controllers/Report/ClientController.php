<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseClient;

class ClientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        $start_date = request("start_date") ?? date("Y-m-01");
        $end_date = request("end_date") ?? date("Y-m-t");

        /* ************************************************** */

        $expenses = ExpenseClient::with('client')
            ->whereHas('expense', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->select('id_client', \DB::raw('SUM(amount) as amount'))
            ->groupBy('id_client')
            ->get();

        $data['general'] = $expenses;

        $chart = $expenses->map(function ($expense) {
            return [
                'name' => $expense['client']['short_name'],
                'y' => floatval($expense['amount']),
            ];
        })->toArray();

        $data['general_chart'] = $chart;

        /* ************************************************** */

        $expenses = ExpenseClient::with('client', 'category')
            ->join('expenses', 'expenses_clients.id_expense', '=', 'expenses.id_expense')
            ->whereHas('expense', function ($query) use ($start_date, $end_date) {
                // $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->select('expenses.id_category', 'expenses_clients.id_client', \DB::raw('SUM(expenses_clients.amount) as amount'))
            ->groupBy('expenses.id_category', 'expenses_clients.id_client')
            ->get();

        $data['clients'] = $expenses;

        $clients = $expenses->groupBy('id_client')->map(function ($group) {
            return $group->first()['client']['short_name'];
        })->toArray();
        asort($clients);

        $data['clients_chart_categories'] = array_values($clients);

        $chart = $expenses->groupBy('id_category')->map(function ($group) use ($clients) {
            $group_clients = collect($group)->keyBy('id_client');
            $group_data = [];
            foreach (array_keys($clients) as $id_client) {
                if (isset($group_clients[$id_client])) {
                    $group_data[] =  +$group_clients[$id_client]['amount'];
                } else {
                    $group_data[] =  0;
                }
            }

            return [
                //'id_category' => $group->first()['id_category'],
                'name' => $group->first()['category']['short_name'],
                //'amount' => $group->sum('amount'),
                'data' => array_values($group_data),
            ];
        })->values()->toArray();

        $data['clients_chart'] = $chart;

        /* ************************************************** */

        return view('reports.clients', compact('data', 'start_date', 'end_date'));
    }
}
