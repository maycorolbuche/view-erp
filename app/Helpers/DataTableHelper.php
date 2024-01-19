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

    public static function systems()
    {
        $data = System::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'systems.show', [$id_field => $row->id_system]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('icon', function ($row) {
                return "<i style='font-size:20px' class='" . $row->icon . "'></i>";
            })
            ->rawColumns(['actions', 'icon'])
            ->make(true);
    }

    public static function clients()
    {
        $data = Client::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'clients.show', [$id_field => $row->id_client]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function branches()
    {
        $data = Branch::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'branches.show', [$id_field => $row->id_branch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->editColumn('name', function ($row) {
                return $row->name . " <span class='label label-info'>" . $row->short_name . "</span>";
            })
            ->rawColumns(['actions', 'name'])
            ->make(true);
    }

    public static function holidays()
    {
        $data = Holiday::with('branches');
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'holidays.show', [$id_field => $row->id_holiday]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
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

    public static function roles()
    {
        $data = Role::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'roles.show', [$id_field => $row->id_role]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function civil_statuses()
    {
        $data = CivilStatus::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'civil-statuses.show', [$id_field => $row->id_civil_status]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function payment_methods()
    {
        $data = PaymentMethod::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'payment-methods.show', [$id_field => $row->id_payment_method]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->editColumn('refundable', function ($row) {
                return ($row->refundable ? "Sim" : "Não");
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function employment_types()
    {
        $data = EmploymentType::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'employment-types.show', [$id_field => $row->id_employment_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function carriers()
    {
        $data = Carrier::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'carriers.show', [$id_field => $row->id_carrier]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function phones_types()
    {
        $data = PhoneType::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'phones-types.show', [$id_field => $row->id_phone_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function relationships_degrees()
    {
        $data = RelationshipDegree::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'relationships-degrees.show', [$id_field => $row->id_relationship_degree]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function authorizations_types()
    {
        $data = AuthorizationType::select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'authorizations-types.show', [$id_field => $row->id_authorization_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->editColumn('approval', function ($row) {
                $items = [
                    'one' => '<span class="badge badge-info"><i class="fas fa-user"></i> Um Responsável</span>',
                    'all' => '<span class="badge badge-success"><i class="fas fa-users"></i> Todos os Responsáveis</span>',
                ];
                return $items[$row->approval];
            })
            ->rawColumns(['actions', 'approval'])
            ->make(true);
    }

    public static function categories()
    {
        $data = Category::with('category_type')->select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'categories.show', [$id_field => $row->id_category]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public static function discounts()
    {
        $data = Discount::with('categories')->select();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'discounts.show', [$id_field => $row->id_discount]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
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

    public static function discounts_amounts()
    {
        $data = DiscountAmount::latest()->where('id_discount', request('pid'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('discounts-amounts.show', ['pid' => request('pid'), 'id' => $row->id_discount_amount]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
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
}
