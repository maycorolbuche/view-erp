<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Models\AuthorizationClient;
use App\Models\AuthorizationStatus;
use App\Models\AuthorizationType;
use App\Models\UserCash;
use App\Helpers\AuthorizationHelper;
use App\Http\Requests\AuthorizationCashAdvanceRequest;
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
        return view('queries.authorizations');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Authorization::with(['statuses', 'authorization_parent'])->find($id);
        if ($data) {
            return view('queries.authorizations', compact('data'));
        } else {
            return redirect()->route('queries-authorizations')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        $data = Authorization::with(['clients', 'statuses', 'user', 'authorization_type'])
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
            ->addColumn('type', function ($row) {
                return $row->authorization_type->name;
            })
            ->addColumn('period', function ($row) {
                if ($row->authorization_type->type == 'expense') {
                    return '<span style="display:none">' . $row->start_datetime . $row->end_datetime . '</span>'
                        . Carbon::parse($row->start_datetime)->format('d/m/Y')
                        . ' a '
                        . Carbon::parse($row->end_datetime)->format('d/m/Y');
                } elseif ($row->authorization_type->type == 'cash-advance' || $row->authorization_type->type == 'cash-advance-return') {
                    return '<span style="display:none">' . $row->start_datetime . '</span>'
                        . Carbon::parse($row->start_datetime)->format('d/m/Y');
                } else {
                    return '';
                }
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
            ->addColumn('description', function ($row) {
                $html = '';
                if ($row->authorization_type->type == 'cash-advance' || $row->authorization_type->type == 'cash-advance-return') {
                    $html .= 'Valor: <b>R$ ' . number_format(abs($row->amount), 2, ',', '.') . '</b> | ';
                }
                return $html . $row->description;
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
            ->rawColumns(['actions', 'start_date', 'end_date', 'clients', 'statuses', 'status', 'period', 'description'])
            ->make(true);
    }
}
