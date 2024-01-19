<?php

namespace App\Helpers;

use App\Models\Expense;
use App\Models\Batch;
use App\Models\Authorization;

use Carbon\Carbon;
use DataTables;

class DataTableHelper
{

    public static function expenses($where = [])
    {
        $data = Expense::with(['category', 'user', 'payment_method'])->where($where);
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'expenses.show', [$id_field => $row->id_expense]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="fas fa-search"></i></a>';
                return $actionBtn;
            })
            ->editColumn('date', function ($row) {
                return Carbon::parse($row->date)->format('d/m/Y');
            }, true, false, 'date')

            ->editColumn('amount', function ($row) {
                return number_format($row->amount, 2, ',', '.');
            })
            ->addColumn('refundable', function ($row) {
                return $row->payment_method->refundable;
            })
            ->editColumn('payment_method.refundable', function ($row) {
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
                        . "</span> ";
                }
                return $html;
            })
            ->rawColumns(['actions',  'payment_method.refundable', 'clients'])
            ->make(true);
    }

    public static function batches($where = [])
    {
        $data = Batch::with(['user'])->where($where);
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'queries-batches.show', [$id_field => $row->id_batch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="fas fa-search"></i></a>';
                return $actionBtn;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('refundable_amount', function ($row) {
                return number_format($row->refundable_amount, 2, ',', '.');
            })
            ->editColumn('non_refundable_amount', function ($row) {
                return number_format($row->non_refundable_amount, 2, ',', '.');
            })
            ->editColumn('amount', function ($row) {
                return number_format($row->amount, 2, ',', '.');
            })
            ->editColumn('active', function ($row) {
                return $row->active ? "<span class='badge badge-success'>Ativo</span>" : "<span class='badge badge-danger'>Fechado</span>";
            })
            ->rawColumns(['actions', 'created_at', 'active'])
            ->make(true);
    }

    public static function authorizations($id_user = 0)
    {
        $data = Authorization::with(['clients', 'statuses', 'user', 'authorization_type']);
        if ($id_user > 0) {
            $data->whereHas('statuses', function ($query) use ($id_user) {
                $query->where('authorizations_statuses.id_user', $id_user);
            })
                ->orWhere(['authorizations.id_user' => $id_user]);
        }
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-authorizations.show', [$id_field => $row->id_authorization]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="fas fa-search"></i></a>';
                return $actionBtn;
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
            ->editColumn('start_date', function ($row) {
                return Carbon::parse($row->start_datetime)->format('d/m/Y');
            })
            ->editColumn('end_date', function ($row) {
                return  Carbon::parse($row->end_datetime)->format('d/m/Y');
            })
            ->addColumn('clients', function ($row) {
                $clients = '';
                foreach ($row->clients as $client) {
                    $clients .= "<span class='label label-info'>" . $client->short_name . "</span> ";
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
            ->editColumn('approved', function ($row) {
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
            ->editColumn('description', function ($row) {
                $html = '';
                if ($row->authorization_type->type == 'cash-advance' || $row->authorization_type->type == 'cash-advance-return') {
                    $html .= 'Valor: <b>R$ ' . number_format(abs($row->amount), 2, ',', '.') . '</b> | ';
                }
                return $html . $row->description;
            })
            ->rawColumns(['actions', 'period', 'clients', 'statuses', 'approved', 'description'])
            ->make(true);
    }
}
