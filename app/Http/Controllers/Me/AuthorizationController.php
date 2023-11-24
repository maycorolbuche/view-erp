<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Helpers\Authorization as AuthorizationHelper;
use App\Models\Authorization;
use App\Models\AuthorizationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AuthorizationNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use DataTables;

class AuthorizationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending = AuthorizationHelper::pending();
        return view('me.authorizations.index', compact('pending'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Authorization::with('statuses')->find($id);
        if ($data) {
            $pending = AuthorizationHelper::pending();
            $edit = AuthorizationHelper::pendingAuthorization($id);

            return view('me.authorizations.index', compact('data', 'pending', 'edit'));
        } else {
            return redirect()->route('me-authorizations')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = AuthorizationHelper::pendingAuthorization($id);
        if (!$edit) {
            return redirect()->back()->with('error', 'Você não tem permissão autorizar/negar este item!')->withInput();
        }

        try {
            $authorization = Authorization::find($id);
            if ($authorization) {
                $status = $request->status;
                if ($status == "") {
                    return redirect()->back()->with('error', 'Uma resposta deve ser escolhida!')->withInput();
                }

                $description = $request->description;
                if ($status == "N" && trim($description) == "") {
                    return redirect()->back()->with('error', 'O motivo da recusa deve ser informado!')->withInput();
                }

                $authorization_status = AuthorizationStatus::where(['id_authorization' => $id, 'id_user' => Auth::id()]);
                if ($authorization_status) {
                    $authorization_status->update(['id_authorization' => $id, 'id_user' => Auth::id(), 'approved' => $status == 'S', 'description' => $description]);
                    AuthorizationHelper::refresh($id);

                    try {
                        $this->sendMail($id);
                        return redirect()->route('me-authorizations.show', ['id' => $authorization->id_authorization])->with('success', 'Status atualizado com sucesso');
                    } catch (\Exception $e) {
                        return redirect()->back()->with('error', 'O status foi salvo com sucesso, porém, houve um erro ao enviar e-mail aos envolvidos.')->withInput();
                    }
                }
            } else {
                return redirect()->route('me-authorizations')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        $data = Authorization::with(['clients', 'statuses', 'user'])
            ->whereHas('statuses', function ($query) {
                $query->where('authorizations_statuses.id_user', Auth::id());
            })
            ->orWhere(['id_user' => Auth::id()])
            ->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-authorizations.show', [$id_field => $row->id_authorization]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('start_date', function ($row) {
                return ($row->start_datetime ? '<span style="display:none">' . $row->start_datetime . '</span>' . Carbon::parse($row->start_datetime)->format('d/m/Y') : '');
            })
            ->addColumn('end_date', function ($row) {
                return ($row->end_datetime ? '<span style="display:none">' . $row->end_datetime . '</span>' . Carbon::parse($row->end_datetime)->format('d/m/Y') : '');
            })
            ->addColumn('clients', function ($row) {
                $clients = '';
                foreach ($row->clients as $client) {
                    $clients .= "<span class='badge badge-info'>" . $client->short_name . "</span> ";
                }
                return $clients;
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

    public function sendMail($id_authorization)
    {

        $authorization = Authorization::where('id_authorization', $id_authorization)
            ->with(['clients', 'statuses', 'authorization_type', 'user'])
            ->first();

        foreach ($authorization->statuses as $user) {
            Notification::send($user, new AuthorizationNotification($authorization, 'status'));
        }
        Notification::send($authorization->user, new AuthorizationNotification($authorization, 'status'));
    }
}
