<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseClient;
use App\Models\ExpenseUser;

class ExpenseController extends Controller
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

        $expenses = Expense::with('category')
            ->whereBetween('date', [$start_date, $end_date])
            ->select('id_category', \DB::raw('SUM(amount) as amount'))
            ->groupBy('id_category')
            ->get();

        $data['general'] = $expenses;

        $chart = $expenses->map(function ($expense) {
            return [
                'name' => $expense['category']['short_name'] ?? $expense['category']['name'],
                'y' => floatval($expense['amount']),
            ];
        })->toArray();

        $data['general_chart'] = $chart;

        /* ************************************************** */

        $expenses = ExpenseClient::with('client', 'category')
            ->join('expenses', 'expenses_clients.id_expense', '=', 'expenses.id_expense')
            ->whereHas('expense', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->select('expenses.id_category', 'expenses_clients.id_client', \DB::raw('SUM(expenses_clients.amount) as amount'))
            ->groupBy('expenses.id_category', 'expenses_clients.id_client')
            ->get();

        $data['clients'] = $expenses;

        $categories = $expenses->groupBy('id_category')->map(function ($group) {
            return $group->first()['category']['short_name'] ?? $group->first()['category']['name'];
        })->toArray();
        asort($categories);

        $data['clients_chart_categories'] = array_values($categories);

        $chart = $expenses->groupBy('id_client')->map(function ($group) use ($categories) {
            $group_categories = collect($group)->keyBy('id_category');
            $group_data = [];
            foreach (array_keys($categories) as $id_client) {
                if (isset($group_categories[$id_client])) {
                    $group_data[] =  +$group_categories[$id_client]['amount'];
                } else {
                    $group_data[] =  0;
                }
            }

            return [
                'name' => $group->first()['client']['short_name'] ?? $group->first()['client']['name'],
                'data' => array_values($group_data),
            ];
        })->values()->toArray();

        $data['clients_chart'] = $chart;

        /* ************************************************** */

        $expenses = ExpenseUser::with('user', 'category')
            ->join('expenses', 'expenses_users.id_expense', '=', 'expenses.id_expense')
            ->whereHas('expense', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->select('expenses.id_category', 'expenses_users.id_user', \DB::raw('SUM(expenses_users.amount) as amount'))
            ->groupBy('expenses.id_category', 'expenses_users.id_user')
            ->get();

        $data['users'] = $expenses;

        $categories = $expenses->groupBy('id_category')->map(function ($group) {
            return $group->first()['category']['short_name'] ?? $group->first()['category']['name'];
        })->toArray();
        asort($categories);

        $data['users_chart_categories'] = array_values($categories);

        $chart = $expenses->groupBy('id_user')->map(function ($group) use ($categories) {
            $group_categories = collect($group)->keyBy('id_category');
            $group_data = [];
            foreach (array_keys($categories) as $id_user) {
                if (isset($group_categories[$id_user])) {
                    $group_data[] =  +$group_categories[$id_user]['amount'];
                } else {
                    $group_data[] =  0;
                }
            }

            return [
                'name' => $group->first()['user']['short_name'] ?? $group->first()['user']['name'],
                'data' => array_values($group_data),
            ];
        })->values()->toArray();

        $data['users_chart'] = $chart;

        /* ************************************************** */

        return view('reports.expenses', compact('data', 'start_date', 'end_date'));
    }
}
