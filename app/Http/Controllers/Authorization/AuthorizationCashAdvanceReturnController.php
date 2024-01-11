<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Models\AuthorizationClient;
use App\Models\AuthorizationStatus;
use App\Models\AuthorizationType;
use App\Models\UserCash;
use App\Helpers\AuthorizationHelper;
use App\Http\Requests\AuthorizationCashAdvanceReturnRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AuthorizationNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use DataTables;

class AuthorizationCashAdvanceReturnController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = AuthorizationHelper::users('cash-advance-return');
        $user_cash = UserCash::where('id_user', Auth::id())->first();
        if (!$user_cash) {
            $user_cash = new \stdClass();
            $user_cash->amount = 0;
        }
        return view('authorizations-cash-advance-returns.index', compact('parents', 'user_cash'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationCashAdvanceReturnRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        $parents = AuthorizationHelper::users('cash-advance-return');
        if (count($parents) <= 0) {
            return redirect()->back()->with('error', 'Não há nenhuma pessoa cadastrada para aprovar suas despesas! Entre em contato com o administrador do sistema.')->withInput();
        }

        $authorization_type = AuthorizationType::where('type', 'cash-advance-return')->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        $authorization_count = Authorization::where(['id_user' => Auth::id(), 'id_authorization_type' => $authorization_type[0], 'active' => true])->count();
        if ($authorization_count > 0) {
            return redirect()->back()->with('error', 'Já existe uma solicição de devolução em andamento. Aguarde a conclusão desta solicitação antes de solicitar novamente!')->withInput();
        }

        $request->merge([
            'amount' => $request->amount * -1
        ]);

        try {
            $authorization_expense = Authorization::create($request->all());
            $this->authorizationsUsers($authorization_expense->id_authorization, $parents ?? []);

            try {
                //$this->sendMail($authorization_expense->id_authorization);
                return redirect()->route('authorizations-cash-advance-returns')->with('success', 'Autorização solicitada com sucesso.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'A solicitação de devolução foi cadastrada com sucesso, porém, houve um erro ao enviar e-mail aos seus responsáveis. Favor, entrar em contato com seus responsáveis! - ' . $e->getMessage())->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        $authorization_type = AuthorizationType::where('type', 'cash-advance-return')->select('id_authorization_type')->pluck('id_authorization_type')->toArray();


        $data = Authorization::where(['id_user' => Auth::id(), 'id_authorization_type' => $authorization_type[0]])
            ->with(['clients', 'statuses'])->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-authorizations.show', [$id_field => $row->id_authorization]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('start_date', function ($row) {
                return ($row->start_datetime ? '<span style="display:none">' . $row->start_datetime . '</span>' . Carbon::parse($row->start_datetime)->format('d/m/Y') : '');
            })
            ->addColumn('end_date', function ($row) {
                return ($row->end_datetime ? '<span style="display:none">' . $row->end_datetime . '</span>' . Carbon::parse($row->end_datetime)->format('d/m/Y') : '');
            })
            ->addColumn('amount', function ($row) {
                return number_format($row->amount, 2, ',', '.');
            })
            ->addColumn('statuses', function ($row) {
                $users = '';
                foreach ($row->statuses as $user) {
                    $class = ($user->pivot->approved === 1
                        ? 'success'
                        : ($user->pivot->approved === 0
                            ? 'danger'
                            : ($row->approved === null && $row->active === 1 ? 'warning' : 'muted')
                        )
                    );
                    $users .= "<span class='badge badge-$class'>" . $user->short_name . "</span> ";
                }
                return $users;
            })
            ->addColumn('status', function ($row) {
                return ($row->approved === 1
                    ? "<span class='badge badge-success'>Aprovado</span>"
                    : ($row->approved === 0
                        ? "<span class='badge badge-danger'>Negado</span>"
                        : ($row->active === 1
                            ? "<span class='badge badge-warning'>Aguardando</span>"
                            : "<span class='badge badge-muted'>Expirado</span>"
                        )
                    )
                );
            })
            ->rawColumns(['actions', 'start_date', 'end_date', 'clients', 'statuses', 'status'])
            ->make(true);
    }

    public function authorizationsClients($id_authorization, $clients)
    {
        AuthorizationClient::where('id_authorization', $id_authorization)->delete();
        if ($clients && count($clients) > 0) {
            foreach (array_values($clients) as $id_client) {
                AuthorizationClient::create(['id_authorization' => $id_authorization, 'id_client' => $id_client]);
            }
        }
    }

    public function authorizationsUsers($id_authorization, $users)
    {
        AuthorizationStatus::where('id_authorization', $id_authorization)->delete();
        if ($users && count($users) > 0) {
            foreach ($users as $user) {
                AuthorizationStatus::create(['id_authorization' => $id_authorization, 'id_user' => $user["id_user"]]);
            }
        }
    }

    public function sendMail($id_authorization)
    {

        $authorization = Authorization::where('id_authorization', $id_authorization)
            ->with(['clients', 'statuses', 'authorization_type', 'user'])
            ->first();

        foreach ($authorization->statuses as $user) {
            Notification::send($user, new AuthorizationNotification($authorization));
        }
        Notification::send($authorization->user, new AuthorizationNotification($authorization));
    }
}
