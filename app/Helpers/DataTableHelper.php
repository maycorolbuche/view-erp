<?php

namespace App\Helpers;

use App\Models\Expense;
use App\Models\Batch;
use App\Models\Authorization;
use App\Models\System;
use App\Models\Client;
use App\Models\Branch;
use App\Models\Holiday;
use App\Models\Role;
use App\Models\CivilStatus;
use App\Models\PaymentMethod;
use App\Models\EmploymentType;
use App\Models\Carrier;
use App\Models\PhoneType;
use App\Models\RelationshipDegree;
use App\Models\AuthorizationType;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountAmount;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\UserTeam;
use App\Models\UserDependent;
use App\Models\UserRole;
use App\Models\UserVacation;
use App\Models\UserPayment;
use App\Models\UserPension;
use App\Models\UserCertification;
use App\Models\UserSickLeave;
use App\Models\UserWarning;
use App\Models\UserCashHistory;
use App\Models\Transaction;
use App\Models\Profile;
use App\Models\NotificationLog;
use App\Models\TaskLog;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DataTableHelper
{

    public static function memo(?string $content = "", string $title = 'Detalhes'): string
    {
        $id = md5($title . $content . microtime());

        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        return '
            <div style="display: flex;align-items: center;justify-content: center;">
                <button 
                    type="button" 
                    class="btn btn-xs btn-primary"
                    data-toggle="modal"
                    data-target="#memoModal' . $id . '">
                    Ver
                </button>
            </div>

            <div class="modal fade" id="memoModal' . $id . '" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>

                            <h4 class="modal-title">' . $title . '</h4>
                        </div>

                        <div class="modal-body">
                            <pre style="white-space: pre-wrap; word-break: break-word;">' . $content . '</pre>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Fechar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        ';
    }

    public static function expenses($query = null)
    {
        $data = $query ?: Expense::query();
        $data->with(['category', 'user', 'payment_method', 'authorization']);
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->filter(function ($query) {
                if ($f = request('start_date')) {
                    $query->whereDate('date', '>=', $f);
                }
                if ($f = request('end_date')) {
                    $query->whereDate('date', '<=', $f);
                }
                if ($f = request('id_batch')) {
                    $query->where('id_batch', $f);
                }
                if ($f = request('id_category')) {
                    $query->where('id_category', $f);
                }
                if ($f = request('id_payment_method')) {
                    $query->where('id_payment_method', $f);
                }
                if ($f = request('id_user')) {
                    $query->whereHas('users', function ($q) use ($f) {
                        $q->where('users.id_user', $f);
                    });
                }
                if ($f = request('id_client')) {
                    $query->whereHas('clients', function ($q) use ($f) {
                        $q->where('clients.id_client', $f);
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'expenses.show', [$id_field => $row->id_expense]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('actions_search', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'expenses.show', [$id_field => $row->id_expense]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="bi bi-search"></i></a>';
                return $actionBtn;
            })
            ->addColumn('file_preview', function ($row) use ($id_field) {
                $actionBtn = "";
                if ($row->file) {
                    $actionBtn = '<a href="' . $row->file->url . '" target="_blank" class="edit btn btn-danger btn-sm" data-type="file"><i class="bi bi-file-earmark-text"></i></a>';
                }
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
            ->addColumn('batch_status', function ($row) {
                return $row->batch ? "<span class='badge badge-" . $row->batch->status["color"] . "'>" . $row->batch->status["label"] . "</span>" : "";
            })
            ->rawColumns(['actions', 'actions_search', 'file_preview', 'payment_method.refundable', 'clients', 'batch_status'])
            ->make(true);
    }

    public static function batches($query = null)
    {
        $data = $query ?: Batch::query();
        $data->with(['user']);
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->filter(function ($query) {
                if ($f = request('start_date')) {
                    $query->whereDate('created_at', '>=', $f);
                }
                if ($f = request('end_date')) {
                    $query->whereDate('created_at', '<=', $f);
                }
                if ($f = request('id_user')) {
                    $query->where('id_user', $f);
                }
            })
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'queries-batches.show', [$id_field => $row->id_batch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('actions_search', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'queries-batches.show', [$id_field => $row->id_batch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="bi bi-search"></i></a>';
                return $actionBtn;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->editColumn('revised_at', function ($row) {
                return Carbon::parse($row->revised_at)->format('d/m/Y');
            })
            ->editColumn('estimated_payment_date', function ($row) {
                return Carbon::parse($row->estimated_payment_date)->format('d/m/Y');
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
            ->addColumn('status', function ($row) {
                return "<span class='badge badge-" . $row->status["color"] . "'>" . $row->status["label"] . "</span>"
                    . (
                        $row->status["type"] == "reviewed" && $row->estimated_payment_date
                        ? "<br><small>Previsão pgto.: " . Carbon::parse($row->estimated_payment_date)->format('d/m/Y') . "</small>"
                        : ""
                    );
            })
            ->rawColumns(['actions', 'actions_search', 'created_at', 'active', 'status'])
            ->make(true);
    }

    public static function authorizations($query = null)
    {
        $data = $query ?: Authorization::query();
        $data->with(['clients', 'statuses', 'user', 'authorization_type']);
        $id_field = request('id-field') ?: 'id';

        $data->select([
            'id_authorization',
            'id_authorization_parent',
            'id_user',
            'id_authorization_type',
            'description',
            'start_datetime',
            'end_datetime',
            'amount',
            'self',
            'active',
            'approved',
            DB::raw('CONCAT(start_datetime, " ", end_datetime) as period'),
            DB::raw('DATE(start_datetime) as start_date'),
            DB::raw('DATE(end_datetime) as end_date'),
        ]);


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-authorizations.show', [$id_field => $row->id_authorization]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('actions_search', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-authorizations.show', [$id_field => $row->id_authorization]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="bi bi-search"></i></a>';
                return $actionBtn;
            })
            ->addColumn('period', function ($row) {
                if ($row->authorization_type->type == 'expense') {
                    return Carbon::parse($row->start_datetime)->format('d/m/Y')
                        . ' a '
                        . Carbon::parse($row->end_datetime)->format('d/m/Y');
                } elseif ($row->authorization_type->type == 'cash-advance' || $row->authorization_type->type == 'cash-advance-return') {
                    return Carbon::parse($row->start_datetime)->format('d/m/Y');
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
            ->editColumn('amount', function ($row) {
                return number_format($row->amount, 2, ',', '.');
            })
            ->rawColumns(['actions', 'actions_search', 'clients', 'statuses', 'approved', 'description'])
            ->make(true);
    }

    public static function systems($query = null)
    {
        $data = $query ?: System::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'systems.show', [$id_field => $row->id_system]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('icon', function ($row) {
                return "<i style='font-size:20px' class='" . $row->icon . "'></i>";
            })
            ->rawColumns(['actions', 'icon'])
            ->make(true);
    }

    public static function clients($query = null)
    {
        $data = $query ?: Client::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'clients.show', [$id_field => $row->id_client]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function branches($query = null)
    {
        $data = $query ?: Branch::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'branches.show', [$id_field => $row->id_branch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('name', function ($row) {
                return $row->name . " <span class='label label-info'>" . $row->short_name . "</span>";
            })
            ->rawColumns(['actions', 'name'])
            ->make(true);
    }

    public static function holidays($query = null)
    {
        $data = $query ?: Holiday::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'holidays.show', [$id_field => $row->id_holiday]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('date', function ($row) {
                $date = strtotime(($row->year ?? date("Y")) . "-" . $row->month . "-" . $row->day);

                if ($row->easter || $row->easter == "0") {
                    $easterTimestamp = easter_date();
                    $date = $easterTimestamp + ($row->easter * 24 * 60 * 60);
                    return '<span style="display:none">' . $date . '</span>' . "<span class='text-warning'>" . date("d/m/Y", $date) . "</span>";
                } elseif ($row->year) {
                    return '<span style="display:none">' . $date . '</span>' . date("d/m/Y", $date);
                } else {
                    return '<span style="display:none">' . $date . '</span>' . date("d/m/", $date) .  "<span class='text-warning'>" . date("Y", $date) . "</span>";
                }
            })
            ->addColumn('type', function ($row) {
                $type = $row->easter !== null ? "easter" : ($row->year == null ? "repeat" : "unique");
                $items = [
                    'unique' => ['Único', 'info'],
                    'repeat' => ['Recorrente', 'success'],
                    'easter' => ['Dinâmico', 'warning']
                ];

                return "<span class='badge badge-" . $items[$type][1] . "'>" . $items[$type][0] . "</span>"
                    . ($type == "easter" ? " <span class='badge badge-info'>🐇 " . ($row->easter > 0 ? "+" : "") . $row->easter . "</span>" : "");
            })
            ->addColumn('branches', function ($row) {
                $branches = '';
                foreach ($row->branches as $branch) {
                    $branches .= "<span class='badge badge-info'>" . $branch->short_name . "</span> ";
                }
                return $branches;
            })
            ->rawColumns(['actions', 'date', 'type', 'branches'])
            ->make(true);
    }

    public static function roles($query = null)
    {
        $data = $query ?: Role::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'roles.show', [$id_field => $row->id_role]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function civil_statuses($query = null)
    {
        $data = $query ?: CivilStatus::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'civil-statuses.show', [$id_field => $row->id_civil_status]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function payment_methods($query = null)
    {
        $data = $query ?: PaymentMethod::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'payment-methods.show', [$id_field => $row->id_payment_method]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('refundable', function ($row) {
                return ($row->refundable ? "Sim" : "Não");
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function employment_types($query = null)
    {
        $data = $query ?: EmploymentType::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'employment-types.show', [$id_field => $row->id_employment_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function carriers($query = null)
    {
        $data = $query ?: Carrier::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'carriers.show', [$id_field => $row->id_carrier]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function phones_types($query = null)
    {
        $data = $query ?: PhoneType::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'phones-types.show', [$id_field => $row->id_phone_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function relationships_degrees($query = null)
    {
        $data = $query ?: RelationshipDegree::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'relationships-degrees.show', [$id_field => $row->id_relationship_degree]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function authorizations_types($query = null)
    {
        $data = $query ?: AuthorizationType::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'authorizations-types.show', [$id_field => $row->id_authorization_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('approval', function ($row) {
                $items = [
                    'one' => '<span class="badge badge-info"><i class="bi bi-person-fill"></i> Um Responsável</span>',
                    'all' => '<span class="badge badge-success"><i class="bi bi-people-fill"></i> Todos os Responsáveis</span>',
                ];
                return $items[$row->approval];
            })
            ->rawColumns(['actions', 'approval'])
            ->make(true);
    }

    public static function categories($query = null)
    {
        $data = $query ?: Category::query();
        $data->with('category_type');
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'categories.show', [$id_field => $row->id_category]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function discounts($query = null)
    {
        $data = $query ?: Discount::query();
        $data->with('categories');
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'discounts.show', [$id_field => $row->id_discount]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('categories', function ($row) {
                $html = "";
                foreach ($row->categories as $category) {
                    $html .= "<span class='badge badge-info'>" . $category->short_name . "</span> ";
                }
                return $html;
            })
            ->rawColumns(['actions', 'categories'])
            ->make(true);
    }

    public static function discounts_amounts($query = null)
    {
        $data = $query ?: DiscountAmount::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('discounts-amounts.show', ['pid' => request('pid'), 'id' => $row->id_discount_amount]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('date', function ($row) {
                return Carbon::parse($row->date)->format('d/m/Y');
            })
            ->editColumn('amount', function ($row) {
                return number_format($row->amount, 2, ',', '.');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users($query = null)
    {
        $data = $query ?: User::query();
        $data->with(['branch']);

        $id_system = request('__id_system');
        $system = System::where('id_system', $id_system)->first();

        if ($system->root != true) {
            $data->where('root', false);
        }
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'users.show', [$id_field => $row->id_user]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('search', function ($row) use ($id_field) {
                $params = [
                    'id'   => $row->id_user,
                    'nome' => $row->name,
                    'email' => $row->email,
                ];
                $json = htmlspecialchars(json_encode($params), ENT_QUOTES, 'UTF-8');

                $actionBtn = '<a onclick=\'sendParams(' . $json . ');\' class="edit btn btn-info btn-sm"><i class="bi bi-search"></i></a>';
                return $actionBtn;
            })
            ->editColumn('branch.name', function ($row) {
                return $row->branch->name ?? '';
            })
            ->rawColumns(['actions', 'search'])
            ->make(true);
    }

    public static function users_phones($query = null)
    {
        $data = $query ?: UserPhone::query();
        $data->with(['carrier', 'phone_type']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-phones.show', ['pid' => request('pid'), 'id' => $row->id_user_phone]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('carrier.name', function ($row) {
                return $row->carrier->name ?? '';
            })
            ->editColumn('phone_type.description', function ($row) {
                return $row->phone_type->description ?? '';
            })
            ->editColumn('phone', function ($row) {
                return $row->phone
                    . ($row->has_whatsapp ? " <i class='bi bi-whatsapp text-success'></i>" : "")
                    . ($row->is_business ? " <i class='bi bi-building text-info'></i>" : "")
                    ?? '';
            })
            ->rawColumns(['actions', 'phone'])
            ->make(true);
    }

    public static function users_teams($query = null)
    {
        $data = $query ?: UserTeam::query();
        $data->with(['parent', 'child']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-teams.show', ['pid' => request('pid'), 'id' => $row->id_user_team]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->addColumn('name', function ($row) {
                if ($row->id_user_parent == request('pid')) {
                    return $row->child->name ?? '';
                } else {
                    return $row->parent->name ?? '';
                }
            })
            ->addColumn('email', function ($row) {
                if ($row->id_user_parent == request('pid')) {
                    return $row->child->email ?? '';
                } else {
                    return $row->parent->email ?? '';
                }
            })
            ->addColumn('relationship', function ($row) {
                if ($row->id_user_parent == request('pid')) {
                    return '<span class="badge badge-warning"><i class="bi bi-people-fill"></i> Subordinado</span>';
                } else {
                    return '<span class="badge badge-danger"><i class="bi bi-person-fill"></i> Superior</span>';
                }
            })
            ->addColumn('authorizations', function ($row) {
                $return = "";
                foreach ($row->users_authorizations_types as $authorization) {
                    $authorizationtype = AuthorizationType::where('id_authorization_type', $authorization->id_authorization_type)->first();
                    if ($authorizationtype) {
                        $return .= " <span class='badge badge-info'>" . $authorizationtype->name . "</span> ";
                    }
                }
                return $return;
            })
            ->rawColumns(['actions', 'relationship', 'authorizations'])
            ->make(true);
    }

    public static function users_dependents($query = null)
    {
        $data = $query ?: UserDependent::query();
        $data->with('relationship_degree');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-dependents.show', ['pid' => request('pid'), 'id' => $row->id_user_dependent]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('birth_date', function ($row) {
                return Carbon::parse($row->birth_date)->format('d/m/Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_roles($query = null)
    {
        $data = $query ?: UserRole::query();
        $data->with('role');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-roles.show', ['pid' => request('pid'), 'id' => $row->id_user_role]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('start_date', function ($row) {
                return Carbon::parse($row->start_date)->format('d/m/Y');
            })
            ->editColumn('end_date', function ($row) {
                return Carbon::parse($row->end_date)->format('d/m/Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_vacations($query = null)
    {
        $data = $query ?: UserVacation::query();
        $data->select([
            'id_user_vacation',
            'id_user',
            'start_date_acquisition_period',
            'end_date_acquisition_period',
            'start_date_requested_period',
            'end_date_requested_period',
            'start_date_approval_period',
            'end_date_approval_period',
            'start_date_approved_period',
            'end_date_approved_period',
            'start_date',
            'end_date',
            DB::raw('CONCAT(start_date, " ", end_date) as period'),
            DB::raw('CONCAT(start_date_acquisition_period, " ", end_date_acquisition_period) as acquisition_period'),
            DB::raw('CONCAT(start_date_requested_period, " ", end_date_requested_period) as requested_period'),
            DB::raw('CONCAT(start_date_approval_period, " ", end_date_approval_period) as approval_period'),
            DB::raw('CONCAT(start_date_approved_period, " ", end_date_approved_period) as approved_period'),
        ]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-vacations.show', ['pid' => request('pid'), 'id' => $row->id_user_vacation]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('start_date', function ($row) {
                return  Carbon::parse($row->start_date)->format('d/m/Y');
            })
            ->editColumn('end_date', function ($row) {
                return  Carbon::parse($row->end_date)->format('d/m/Y');
            })
            ->editColumn('acquisition_period', function ($row) {
                $start = "";
                if ($row->start_date_acquisition_period) {
                    $start = Carbon::parse($row->start_date_acquisition_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_acquisition_period) {
                    $end = Carbon::parse($row->end_date_acquisition_period)->format('d/m/Y');
                }

                return $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->editColumn('requested_period', function ($row) {
                $start = "";
                if ($row->start_date_requested_period) {
                    $start = Carbon::parse($row->start_date_requested_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_requested_period) {
                    $end = Carbon::parse($row->end_date_requested_period)->format('d/m/Y');
                }

                return $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->editColumn('approval_period', function ($row) {
                $start = "";
                if ($row->start_date_approval_period) {
                    $start = Carbon::parse($row->start_date_approval_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_approval_period) {
                    $end = Carbon::parse($row->end_date_approval_period)->format('d/m/Y');
                }

                return $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->editColumn('approved_period', function ($row) {
                $start = "";
                if ($row->start_date_approved_period) {
                    $start = Carbon::parse($row->start_date_approved_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_approved_period) {
                    $end = Carbon::parse($row->end_date_approved_period)->format('d/m/Y');
                }

                return $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->editColumn('period', function ($row) {
                $start = "";
                if ($row->start_date) {
                    $start = Carbon::parse($row->start_date)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date) {
                    $end = Carbon::parse($row->end_date)->format('d/m/Y');
                }

                return $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_payments($query = null)
    {
        $data = $query ?: UserPayment::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-payments.show', ['pid' => request('pid'), 'id' => $row->id_user_payment]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('date', function ($row) {
                return Carbon::parse($row->date)->format('d/m/Y');
            })
            ->editColumn('amount', function ($row) {
                return number_format($row->amount, 2, ',', '.');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_pensions($query = null)
    {
        $data = $query ?: UserPension::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-pension.show', ['pid' => request('pid'), 'id' => $row->id_user_pension]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('date', function ($row) {
                return Carbon::parse($row->date)->format('d/m/Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_certifications($query = null)
    {
        $data = $query ?: UserCertification::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-certifications.show', ['pid' => request('pid'), 'id' => $row->id_user_certification]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('start_date', function ($row) {
                return  Carbon::parse($row->start_date)->format('d/m/Y');
            })
            ->editColumn('end_date', function ($row) {
                return Carbon::parse($row->end_date)->format('d/m/Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_sick_leaves($query = null)
    {
        $data = $query ?: UserSickLeave::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-sick-leaves.show', ['pid' => request('pid'), 'id' => $row->id_user_sick_leave]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('start_date', function ($row) {
                return  Carbon::parse($row->start_date)->format('d/m/Y');
            })
            ->editColumn('end_date', function ($row) {
                return  Carbon::parse($row->end_date)->format('d/m/Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_warnings($query = null)
    {
        $data = $query ?: UserWarning::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-warnings.show', ['pid' => request('pid'), 'id' => $row->id_user_warning]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('date', function ($row) {
                return Carbon::parse($row->date)->format('d/m/Y');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_cash($query = null)
    {
        $data = $query ?: User::query()->selectRaw("users.*, users.id_user as id");
        $data->with('user_cash');
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'users.show', [$id_field => $row->id_user ?? 0]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->editColumn('user_cash.amount', function ($row) {
                $amount = 0;
                if ($row->user_cash) {
                    $amount = $row->user_cash->amount;
                }
                return number_format($amount, 2, ',', '.');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function users_cash_history($query = null)
    {
        $data = $query ?: UserCashHistory::query();
        $data->with('transaction');

        return DataTables::of($data)
            ->editColumn('date', function ($row) {
                return  Carbon::parse($row->date)->format('d/m/Y');
            })
            ->editColumn('amount', function ($row) {
                $amount = $row->amount;
                return '<span class="' . ($amount < 0 ? 'text-danger' : ($amount > 0 ? 'text-info' : '')) . '">' . number_format($amount, 2, ',', '.') . '</span>';
            })
            ->editColumn('previous_balance', function ($row) {
                $amount = $row->previous_balance;
                return '<span class="' . ($amount < 0 ? 'text-danger' : ($amount > 0 ? 'text-info' : '')) . '">' . number_format($amount, 2, ',', '.') . '</span>';
            })
            ->editColumn('current_balance', function ($row) {
                $amount = $row->current_balance;
                return '<span class="' . ($amount < 0 ? 'text-danger' : ($amount > 0 ? 'text-info' : '')) . '">' . number_format($amount, 2, ',', '.') . '</span>';
            })
            ->addColumn('description', function ($row) {
                return ($row->transaction ? $row->transaction->description : ($row->id_batch ? '<span class="text-info">Lote ' . $row->id_batch . "</span>" : ''));
            })
            ->addIndexColumn()
            ->rawColumns(['amount', 'previous_balance', 'current_balance', 'description'])
            ->make(true);
    }

    public static function transactions($query = null)
    {
        $data = $query ?: Transaction::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('amount', function ($row) {
                return "<span class='" . ($row->amount < 0 ? "text-danger" : ($row->amount > 0 ? "text-info" : "")) . "'>"
                    . number_format($row->amount, 2, ',', '.')
                    . "</span>";
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->editColumn('description', function ($row) {
                $details = "";
                if ($row->id_batch) {
                    $details .= " <span class='label label-dark'>#Lote " . $row->id_batch . "</span>";
                }
                return $row->description . $details;
            })
            ->rawColumns(['amount', 'description'])
            ->make(true);
    }

    public static function profiles($query = null)
    {
        $data = $query ?: Profile::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'profiles.show', [$id_field => $row->id_profile]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="bi bi-pen"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function notification_logs($query = null)
    {
        $data = $query ?: NotificationLog::query();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'notification-logs.show', [$id_field => $row->id_notification_log]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="bi bi-search"></i></a>';
                return $actionBtn;
            })
            ->editColumn('sent_at', function ($row) {
                return Carbon::parse($row->sent_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('status', function ($row) {
                return (
                    $row->status == "sent"
                    ? "<span class='badge badge-success'>Enviado</span>"
                    : $row->status
                );
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public static function task_logs($query = null)
    {
        $data = $query ?: TaskLog::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('details', function ($row) {
                return self::memo($row->details);
            })
            ->editColumn('start_time', function ($row) {
                if (!$row->start_time) {
                    return "";
                }
                return Carbon::parse($row->start_time)->format('d/m/Y H:i:s');
            })
            ->editColumn('end_time', function ($row) {
                if (!$row->end_time) {
                    return "";
                }
                return Carbon::parse($row->end_time)->format('d/m/Y H:i:s');
            })
            ->rawColumns(['details'])
            ->make(true);
    }
}
