<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Client;
use App\Http\Requests\ExpenseRequest;
use App\Helpers\AuthorizationHelper;
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
        $authorizations = AuthorizationHelper::active('expense');
        $categories = Category::orderBy('name')->with('category_type')
            ->whereHas('category_type', function ($query) {
                $query->where('categories_types.slug', 'expense');
            })->get();
        $payment_methods = PaymentMethod::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('expenses.index', compact('authorizations', 'categories', 'payment_methods', 'users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $expense = Expense::create($request->all());
            return redirect()->route('expenses.show', ['id' => $expense->id_expense])->with('success', 'Registro cadastrado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Expense::with('authorization')->find($id);
        if ($data) {
            $authorizations = AuthorizationHelper::active('expense');
            $categories = Category::orderBy('name')->with('category_type')
                ->whereHas('category_type', function ($query) {
                    $query->where('categories_types.slug', 'expense');
                })->get();
            $payment_methods = PaymentMethod::orderBy('name')->get();
            $users = User::orderBy('name')->get();
            $clients = Client::orderBy('name')->get();

            return view('expenses.index', compact('data', 'authorizations', 'categories', 'payment_methods', 'users', 'clients'));
        } else {
            return redirect()->route('expenses')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new ExpenseRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $expense = Expense::find($id);
            if ($expense) {
                $expense->update($request->all());
                return redirect()->route('expenses.show', ['id' => $expense->id_expense])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('expenses')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!in_array('destroy', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir nessa página!')->withInput();
        }

        try {
            $expense = Expense::find($id);
            if ($expense) {
                $expense->delete();
                return redirect()->route('expenses')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('expenses')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = Expense::with('category')->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'expenses.show', [$id_field => $row->id_expense]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
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
                return number_format($row->amount, 2, ',', '.');
            })
            ->rawColumns(['actions', 'date'])
            ->make(true);
    }
}
