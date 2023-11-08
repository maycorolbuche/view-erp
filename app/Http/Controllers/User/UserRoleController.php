<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use App\Http\Requests\UserRoleRequest;
use Carbon\Carbon;
use DataTables;

class UserRoleController extends Controller
{
    public function parent()
    {
        return view('users.roles.parent');
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
                $roles = Role::orderBy('name')->get();
                return view('users.roles.index', compact('pid', 'user', 'roles'));
            } else {
                return redirect()->route('users-roles')->with('error', 'Registro não encontrado!');
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
    public function store(UserRoleRequest $request, $pid)
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

            $user_role = UserRole::create($request->all());
            return redirect()->route('users-roles.show', ['pid' => $pid, 'id' => $user_role->id_user_role])->with('success', 'Registro cadastrado com sucesso');
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
            $data = UserRole::find($id);
            if ($data) {
                $roles = Role::orderBy('name')->get();
                return view('users.roles.index', compact('pid', 'data', 'user', 'roles'));
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
    public function update(UserRoleRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserRoleRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_role = UserRole::find($id);
                if ($user_role) {
                    $user_role->update($request->all());
                    return redirect()->route('users-roles.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('users-roles')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-roles')->with('error', 'Registro não encontrado!');
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
                $user_role = UserRole::find($id);
                if ($user_role) {
                    $user_role->delete();
                    return redirect()->route('users-roles.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('users-roles.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-roles.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = UserRole::latest()->where('id_user', request('pid'))->with(['role'])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-roles.show', ['pid' => request('pid'), 'id' => $row->id_user_role]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('role', function ($row) {
                return $row->role->name ?? '';
            })
            ->addColumn('start_date', function ($row) {
                return ($row->start_date ? '<span style="display:none">' . $row->start_date . '</span>' . Carbon::parse($row->start_date)->format('d/m/Y') : '');
            })
            ->addColumn('end_date', function ($row) {
                return ($row->end_date ? '<span style="display:none">' . $row->end_date . '</span>' . Carbon::parse($row->end_date)->format('d/m/Y') : '');
            })
            ->rawColumns(['actions', 'start_date', 'end_date'])
            ->make(true);
    }
}
