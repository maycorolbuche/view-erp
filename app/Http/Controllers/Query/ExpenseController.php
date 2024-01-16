<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Carbon\Carbon;
use DataTables;

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
        $data = Expense::with(['category', 'user'])->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'expenses.show', [$id_field => $row->id_expense]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="fas fa-search"></i></a>';
                return $actionBtn;
            })
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('date', function ($row) {
                return ($row->date ? '<span style="display:none">' . $row->date . '</span>' . Carbon::parse($row->date)->format('d/m/Y') : '');
            })
            ->addColumn('category', function ($row) {
                return $row->category->short_name;
            })
            ->addColumn('payment_method', function ($row) {
                return $row->payment_method->name;
            })
            ->addColumn('amount', function ($row) {
                return '<span style="display:none">' . $row->amount . '</span>' . number_format($row->amount, 2, ',', '.');
            })
            ->addColumn('refundable', function ($row) {
                return $row->payment_method->refundable
                    ? "<span class='badge badge-info'>Reembolsável</span>"
                    : "<span class='badge badge-danger'>Não Reembolsável</span>";
            })
            ->addColumn('clients', function ($row) {
                $html = '';
                foreach ($row->clients as $client) {
                    $html .= "<span class='label label-info' data-toggle='tooltip' data-placement='right' "
                        . "title='" . number_format($client->pivot->percentage, 2, ',', '.') . "% | R$ " . number_format($client->pivot->amount, 2, ',', '.') . "'>"
                        . $client->short_name
                        . "</span>&nbsp;";
                }
                return $html;
            })
            ->rawColumns(['actions', 'date', 'refundable', 'amount', 'clients'])
            ->make(true);
    }
}
