<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\ExpenseUser;

class UserController extends Controller
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

        $expenses = ExpenseUser::with('user')
            ->whereHas('expense', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->select('id_user', \DB::raw('SUM(amount) as amount'))
            ->groupBy('id_user')
            ->get();

        $data['general'] = $expenses;

        $chart = $expenses->map(function ($expense) {
            return [
                'name' => $expense['user']['short_name'] ?? $expense['user']['name'],
                'y' => floatval($expense['amount']),
            ];
        })->toArray();

        $data['general_chart'] = $chart;

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

        $users = $expenses->groupBy('id_user')->map(function ($group) {
            return $group->first()['user']['short_name'] ?? $group->first()['user']['name'];
        })->toArray();
        asort($users);

        $data['users_chart_categories'] = array_values($users);

        $chart = $expenses->groupBy('id_category')->map(function ($group) use ($users) {
            $group_users = collect($group)->keyBy('id_user');
            $group_data = [];
            foreach (array_keys($users) as $id_user) {
                if (isset($group_users[$id_user])) {
                    $group_data[] =  +$group_users[$id_user]['amount'];
                } else {
                    $group_data[] =  0;
                }
            }

            return [
                //'id_category' => $group->first()['id_category'],
                'name' => $group->first()['category']['short_name'] ?? $group->first()['category']['name'],
                //'amount' => $group->sum('amount'),
                'data' => array_values($group_data),
            ];
        })->values()->toArray();

        $data['users_chart'] = $chart;

        /* ************************************************** */

        return view('reports.users', compact('data', 'start_date', 'end_date'));
    }
}
