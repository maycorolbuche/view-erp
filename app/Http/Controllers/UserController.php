<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\System;
use App\Models\EmploymentType;
use App\Models\CivilStatus;
use App\Models\Branch;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employment_types = EmploymentType::all();
        $civil_statuses = CivilStatus::all();
        $branches = Branch::all();
        return view('users.index', compact('employment_types', 'civil_statuses', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        unset($request["root"]);

        if (!$request->username) {
            $username = explode("@", $request->email)[0];
            $user = User::where('username', $username)->get();
            while (count($user->toArray()) > 0) {
                $username = explode("@", $request->email)[0] . Str::random(8);;
                $user = User::where('username', $username)->get();
            }
            $request->merge(['username' => $username]);
        }


        try {
            $user = User::create($request->all());
            return redirect()->route('users.show', ['id' => $user->id_user])->with('success', 'Registro cadastrado com sucesso');
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
    public function show($id)
    {
        $data = User::with('employment_type')->find($id);
        if ($data) {
            $employment_types = EmploymentType::all();
            $civil_statuses = CivilStatus::all();
            $branches = Branch::all();

            return view('users.index', compact('data', 'employment_types', 'civil_statuses', 'branches'));
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
    public function update(UserRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        unset($request["root"]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $user = User::find($id);
            if ($user) {
                $user->update($request->all());
                return redirect()->route('users.show', ['id' => $user->id_user])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
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
    public function destroy($id)
    {
        if (!in_array('destroy', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {
                if ($user->root == true) {
                    return redirect()->back()->with('error', 'Este perfil não pode ser apagado, pois é o perfil raiz.')->withInput();
                }
                $user->delete();
                return redirect()->route('users')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $id_system = request('__id_system');
        $system = System::where('id_system', $id_system)->first();
        if ($system->root == true) {
            $data = User::latest()->get();
        } else {
            $data = User::where('root', false)->latest()->get();
        }
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'users.show', [$id_field => $row->id_user]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
