<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseClient;
use App\Models\ExpenseUser;
use App\Models\User;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Client;
use App\Models\Authorization;
use App\Http\Requests\ExpenseRequest;
use App\Helpers\AuthorizationHelper;
use App\Helpers\ExpenseHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\Auth;

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

        $count = Authorization::where('id_authorization', $request->input('id_authorization'))
            ->where('active', true)
            ->where('approved', true)
            ->count();
        if ($count <= 0) {
            return redirect()->back()->with('error', 'Autorização não encontrada. Verifique se a mesma existe, e se está ativa e aprovada!')->withInput();
        }

        $authorization = Authorization::where('id_authorization', $request->input('id_authorization'))->first();

        try {
            $dates = DateTimeHelper::distribute($request->amount, $request->date, $request->distribute, $authorization->end_date, Auth::user()->id_branch);

            if ($request->distribute <= 1 || count($dates) <= 0) {
                $expense = Expense::create($request->all());
                $this->expensesClients($expense->id_expense, $request->client_amount);
                $this->expensesUsers($expense->id_expense, $request->user_amount);
                ExpenseHelper::refresh($expense->id_expense);
            } else {

                foreach ($dates as $date => $amount) {
                    $request['date'] = $date;
                    $request['amount'] = $amount;
                    $expense = Expense::create($request->all());

                    $accumulated_amount = 0;
                    $client_amount = $request->client_amount;
                    $updated_client_amount = [];
                    $last_id_client = 0;
                    foreach ($client_amount as $id_client => $partial_amount) {
                        if ($partial_amount) {
                            $partial_amount = round($amount * $request->client_percentage[$id_client] / 100, 2);
                            $accumulated_amount += $partial_amount;
                            $updated_client_amount[$id_client] = $partial_amount;
                            $last_id_client = $id_client;
                        }
                    }
                    $updated_client_amount[$last_id_client] += round($amount - $accumulated_amount, 2);
                    $request->merge(['client_amount' => $updated_client_amount]);

                    $this->expensesClients($expense->id_expense, $request->client_amount);


                    $accumulated_amount = 0;
                    $user_amount = $request->user_amount;
                    $updated_user_amount = [];
                    $last_id_user = 0;
                    foreach ($user_amount as $id_user => $partial_amount) {
                        if ($partial_amount) {
                            $partial_amount = round($amount * $request->user_percentage[$id_user] / 100, 2);
                            $accumulated_amount += $partial_amount;
                            $updated_user_amount[$id_user] = $partial_amount;
                            $last_id_user = $id_user;
                        }
                    }
                    $updated_user_amount[$last_id_user] += round($amount - $accumulated_amount, 2);
                    $request->merge(['user_amount' => $updated_user_amount]);

                    $this->expensesUsers($expense->id_expense, $request->user_amount);
                    ExpenseHelper::refresh($expense->id_expense);
                }
            }

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
        $data = Expense::with(['authorization', 'clients', 'users'])
            ->where(['id_expense' => $id, 'id_user' => Auth::id()])->whereNull('id_batch')->first();
        if ($data) {
            $clientsById = array_column($data->clients->toArray(), null, 'id_client');
            $data->clients = $clientsById;

            $usersById = array_column($data->users->toArray(), null, 'id_user');
            $data->users = $usersById;

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

        unset($request['id_authorization']);

        try {
            $expense = Expense::where(['id_expense' => $id, 'id_user' => Auth::id()])->whereNull('id_batch')->first();
            if ($expense) {

                $expense->update($request->all());
                $this->expensesClients($expense->id_expense, $request->client_amount);
                $this->expensesUsers($expense->id_expense, $request->user_amount);
                ExpenseHelper::refresh($expense->id_expense);

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
            $expense = Expense::where(['id_expense' => $id, 'id_user' => Auth::id()])->whereNull('id_batch')->first();
            if ($expense->id_batch) {
                return redirect()->back()->with('error', 'Esta despesa está vinculada a um lote. Não é possível apagá-la!')->withInput();
            }

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
        return DataTableHelper::expenses(['id_user' => Auth::id(), 'id_batch' => null]);
    }

    public function expensesClients($id_expense, $clients)
    {
        $expense = Expense::where('id_expense', $id_expense)->first();
        $authorization = Authorization::where('id_authorization', $expense->id_authorization)
            ->with('clients')->first();

        $clients_list = $authorization->clients->pluck('id_client')->toArray();
        $clients = array_intersect_key($clients, array_flip($clients_list));

        ExpenseClient::where('id_expense', $id_expense)->delete();
        if ($clients && count($clients) > 0) {
            foreach ($clients as $id_client => $amount) {
                if ($amount > 0) {
                    $percentage = $amount / $expense->amount * 100;
                    ExpenseClient::create(['id_expense' => $id_expense, 'id_client' => $id_client, 'amount' => $amount, 'percentage' => $percentage]);
                }
            }
        }
    }

    public function expensesUsers($id_expense, $users)
    {
        $expense = Expense::where('id_expense', $id_expense)->first();

        ExpenseUser::where('id_expense', $id_expense)->delete();
        if ($users && count($users) > 0) {
            foreach ($users as $id_user => $amount) {
                if ($amount > 0) {
                    $percentage = $amount / $expense->amount * 100;
                    ExpenseUser::create(['id_expense' => $id_expense, 'id_user' => $id_user, 'amount' => $amount, 'percentage' => $percentage]);
                }
            }
        }
    }
}
