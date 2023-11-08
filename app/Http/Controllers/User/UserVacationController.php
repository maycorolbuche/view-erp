<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVacation;
use App\Http\Requests\UserVacationRequest;
use Carbon\Carbon;
use DataTables;

class UserVacationController extends Controller
{
    public function parent()
    {
        return view('users.vacations.parent');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pid = $id;
        try {
            $user = User::find($id);
            if ($user) {
                return view('users.vacations.index', compact('pid', 'user'));
            } else {
                return redirect()->route('users-vacations')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserVacationRequest $request, $pid)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        try {
            $user = User::find($pid);
            if (!$user) {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }

            $user_vacation = UserVacation::create($request->all());
            return redirect()->route('users-vacations.show', ['pid' => $pid, 'id' => $user_vacation->id_user_vacation])->with('success', 'Registro cadastrado com sucesso');
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
    public function show($pid, $id)
    {
        $user = User::find($pid);
        if ($user) {
            $data = UserVacation::find($id);
            if ($data) {
                return view('users.vacations.index', compact('pid', 'data', 'user'));
            } else {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }
        } else {
            return redirect()->route('users')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserVacationRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserVacationRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_vacation = UserVacation::find($id);
                if ($user_vacation) {
                    $user_vacation->update($request->all());
                    return redirect()->route('users-vacations.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('users-vacations')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-vacations')->with('error', 'Registro não encontrado!');
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
    public function destroy($pid, $id)
    {
        if (!in_array('destroy', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir nessa página!')->withInput();
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_vacation = UserVacation::find($id);
                if ($user_vacation) {
                    $user_vacation->delete();
                    return redirect()->route('users-vacations.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('users-vacations.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-vacations.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = UserVacation::latest()->where('id_user', request('pid'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-vacations.show', ['pid' => request('pid'), 'id' => $row->id_user_vacation]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('start_date', function ($row) {
                return ($row->start_date ? '<span style="display:none">' . $row->start_date . '</span>' . Carbon::parse($row->start_date)->format('d/m/Y') : '');
            })
            ->addColumn('end_date', function ($row) {
                return ($row->end_date ? '<span style="display:none">' . $row->end_date . '</span>' . Carbon::parse($row->end_date)->format('d/m/Y') : '');
            })
            ->addColumn('acquisition_period', function ($row) {
                $start = "";
                if ($row->start_date_acquisition_period) {
                    $start = Carbon::parse($row->start_date_acquisition_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_acquisition_period) {
                    $end = Carbon::parse($row->end_date_acquisition_period)->format('d/m/Y');
                }

                return '<span style="display:none">' . ($row->start_date_acquisition_period ?? '') . ($row->end_date_acquisition_period ?? '') . '</span>'
                    . $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->addColumn('requested_period', function ($row) {
                $start = "";
                if ($row->start_date_requested_period) {
                    $start = Carbon::parse($row->start_date_requested_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_requested_period) {
                    $end = Carbon::parse($row->end_date_requested_period)->format('d/m/Y');
                }

                return '<span style="display:none">' . ($row->start_date_requested_period ?? '') . ($row->end_date_requested_period ?? '') . '</span>'
                    . $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->addColumn('approval_period', function ($row) {
                $start = "";
                if ($row->start_date_approval_period) {
                    $start = Carbon::parse($row->start_date_approval_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_approval_period) {
                    $end = Carbon::parse($row->end_date_approval_period)->format('d/m/Y');
                }

                return '<span style="display:none">' . ($row->start_date_approval_period ?? '') . ($row->end_date_approval_period ?? '') . '</span>'
                    . $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->addColumn('approved_period', function ($row) {
                $start = "";
                if ($row->start_date_approved_period) {
                    $start = Carbon::parse($row->start_date_approved_period)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date_approved_period) {
                    $end = Carbon::parse($row->end_date_approved_period)->format('d/m/Y');
                }

                return '<span style="display:none">' . ($row->start_date_approved_period ?? '') . ($row->end_date_approved_period ?? '') . '</span>'
                    . $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->addColumn('period', function ($row) {
                $start = "";
                if ($row->start_date) {
                    $start = Carbon::parse($row->start_date)->format('d/m/Y');
                }
                $end = "";
                if ($row->end_date) {
                    $end = Carbon::parse($row->end_date)->format('d/m/Y');
                }

                return '<span style="display:none">' . ($row->start_date ?? '') . ($row->end_date ?? '') . '</span>'
                    . $start . ($start <> "" && $end <> "" ? " - " : "") . $end;
            })
            ->rawColumns([
                'actions',
                'start_date',
                'end_date',
                'acquisition_period',
                'requested_period',
                'approval_period',
                'approved_period',
                'period'
            ])
            ->make(true);
    }
}
