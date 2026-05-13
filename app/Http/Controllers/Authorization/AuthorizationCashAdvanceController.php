<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Models\AuthorizationClient;
use App\Models\AuthorizationStatus;
use App\Models\AuthorizationType;
use App\Helpers\UserHelper;
use App\Helpers\ConfigHelper;
use App\Http\Requests\AuthorizationCashAdvanceRequest;
use App\Notifications\AuthorizationNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\DataTableHelper;

class AuthorizationCashAdvanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorizations = Authorization::getActiveExpenses();
        $parents = AuthorizationType::getUsers('cash-advance');
        $user_cash = UserHelper::getCash(auth()->id());
        $agreement_terms = ConfigHelper::get('authorizations.cash_advance.agreement_terms');
        return view('authorizations-cash-advances.index', compact('authorizations', 'parents', 'user_cash', 'agreement_terms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationCashAdvanceRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        $parents = AuthorizationType::getUsers('cash-advance');
        if (count($parents) <= 0) {
            return redirect()->back()->with('error', 'Não há nenhuma pessoa cadastrada para aprovar suas despesas! Entre em contato com o administrador do sistema.')->withInput();
        }

        $agreement_terms = ConfigHelper::get('authorizations.cash_advance.agreement_terms');
        if ($agreement_terms <> "" && !$request->input("agreement_terms")) {
            return redirect()->back()->with('error', 'Você deve aceitar o termo de compormisso, concordando com seus termos e condições!')->withInput();
        }

        $request->merge(['agreement_terms' => $agreement_terms]);

        try {
            $authorization_expense = Authorization::create($request->all());
            $this->authorizationsUsers($authorization_expense->id_authorization, $parents ?? []);

            try {
                $this->sendMail($authorization_expense->id_authorization);
                return redirect()->route('authorizations-cash-advances')->with('success', 'Autorização solicitada com sucesso.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'A solicitação de adiantamento foi cadastrada com sucesso, porém, houve um erro ao enviar e-mail aos seus responsáveis. Favor, entrar em contato com seus responsáveis! - ' . $e->getMessage())->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::authorizations(Authorization::me()->type('cash-advance'));
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
