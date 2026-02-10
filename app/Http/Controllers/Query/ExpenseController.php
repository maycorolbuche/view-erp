<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Client;
use App\Models\User;
use App\Helpers\DataTableHelper;

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
        return DataTableHelper::expenses();
    }
}
