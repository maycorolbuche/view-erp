<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Models\Client;
use App\Helpers\Authorization as AuthorizationHelper;
use App\Http\Requests\AuthorizationExpenseRequest;
use DataTables;

class AuthorizationExpenseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('name')->get();
        $parents = AuthorizationHelper::users('expense');
        return view('authorizations-expenses.index', compact('clients', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationExpenseRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $authorization_expense = Authorization::create($request->all());
            return redirect()->route('authorizations-expenses.show', ['id' => $authorization_expense->id_authorization_expense])->with('success', 'Registro cadastrado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        $id_system = request('__id_system');
        $data = Authorization::latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                /*$edit_route = route(request('route') ?: 'authorizations-expenses.show', [$id_field => $row->id_authorization_expense]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;*/
                return "";
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
