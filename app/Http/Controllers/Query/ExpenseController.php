<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Expense;
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
        return view('queries.expenses');
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

        if ($data) {
            return view('queries.expenses', compact('data'));
        } else {
            return redirect()->route('queries-expenses')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        return DataTableHelper::expenses();
    }
}
