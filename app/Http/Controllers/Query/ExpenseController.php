<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Client;
use App\Models\User;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name')->with('category_type')
            ->whereHas('category_type', function ($query) {
                $query->where('categories_types.slug', 'expense');
            })->get();
        $payment_methods = PaymentMethod::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('queries.expenses', compact('categories', 'payment_methods', 'clients', 'users'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Expense::with(['user', 'authorization', 'clients', 'users', 'category', 'payment_method'])
            ->where('id_expense', $id)->first();

        $categories = Category::orderBy('name')->with('category_type')
            ->whereHas('category_type', function ($query) {
                $query->where('categories_types.slug', 'expense');
            })->get();
        $payment_methods = PaymentMethod::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        if ($data) {
            return view('queries.expenses', compact('data', 'categories', 'payment_methods', 'clients', 'users'));
        } else {
            return redirect()->route('queries-expenses')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        if (request('type') == 'simulator') {
            $query = Expense::query();
            if ($f = request('start_date')) {
                $query->whereDate('date', '>=', $f);
            }
            if ($f = request('end_date')) {
                $query->whereDate('date', '<=', $f);
            }
            if ($f = request('id_batch')) {
                $query->where('id_batch', $f);
            }
            if ($f = request('id_category')) {
                $query->where('id_category', $f);
            }
            if ($f = request('id_payment_method')) {
                $query->where('id_payment_method', $f);
            }
            if ($f = request('id_user')) {
                $query->whereHas('users', function ($q) use ($f) {
                    $q->where('users.id_user', $f);
                });
            }
            if ($f = request('id_client')) {
                $query->whereHas('clients', function ($q) use ($f) {
                    $q->where('clients.id_client', $f);
                });
            }

            $data = $query
                ->join('categories', 'categories.id_category', '=', 'expenses.id_category')
                ->select(
                    'categories.id_category',
                    'categories.name as category_name',
                    DB::raw('COUNT(DISTINCT expenses.id_user) as total_users'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('COUNT(*) as total_items')
                )
                ->groupBy('id_category', 'categories.name')
                ->orderBy('categories.name')
                ->get();

            return view('queries.partials.expenses-simulator', compact('data'));
        } else {
            return DataTableHelper::expenses();
        }
    }
}
