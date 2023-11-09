<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSickLeave;
use App\Http\Requests\UserSickLeaveRequest;
use Carbon\Carbon;
use DataTables;

class UserSickLeaveController extends Controller
{
    public function parent()
    {
        return view('users.sick-leaves.parent');
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
                return view('users.sick-leaves.index', compact('pid', 'user'));
            } else {
                return redirect()->route('users-sick-leaves')->with('error', 'Registro não encontrado!');
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
    public function store(UserSickLeaveRequest $request, $pid)
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

            $user_sick_leave = UserSickLeave::create($request->all());
            return redirect()->route('users-sick-leaves.show', ['pid' => $pid, 'id' => $user_sick_leave->id_user_sick_leave])->with('success', 'Registro cadastrado com sucesso');
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
            $data = UserSickLeave::find($id);
            if ($data) {
                return view('users.sick-leaves.index', compact('pid', 'data', 'user'));
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
    public function update(UserSickLeaveRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserSickLeaveRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_sick_leave = UserSickLeave::find($id);
                if ($user_sick_leave) {
                    $user_sick_leave->update($request->all());
                    return redirect()->route('users-sick-leaves.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('users-sick-leaves')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-sick-leaves')->with('error', 'Registro não encontrado!');
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
                $user_sick_leave = UserSickLeave::find($id);
                if ($user_sick_leave) {
                    $user_sick_leave->delete();
                    return redirect()->route('users-sick-leaves.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('users-sick-leaves.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-sick-leaves.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = UserSickLeave::latest()->where('id_user', request('pid'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-sick-leaves.show', ['pid' => request('pid'), 'id' => $row->id_user_sick_leave]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('start_date', function ($row) {
                return ($row->start_date ? '<span style="display:none">' . $row->start_date . '</span>' . Carbon::parse($row->start_date)->format('d/m/Y') : '');
            })
            ->addColumn('end_date', function ($row) {
                return ($row->end_date ? '<span style="display:none">' . $row->end_date . '</span>' . Carbon::parse($row->end_date)->format('d/m/Y') : '');
            })
            ->rawColumns([
                'actions',
                'start_date',
                'end_date',
            ])
            ->make(true);
    }
}
