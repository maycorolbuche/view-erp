<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RelationshipDegree;
use App\Models\UserDependent;
use App\Http\Requests\UserDependentRequest;
use App\Helpers\DataTableHelper;

class UserDependentController extends Controller
{
    public function parent()
    {
        return view('users.dependents.parent');
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
                $relationships_degrees = RelationshipDegree::all();
                return view('users.dependents.index', compact('pid', 'user', 'relationships_degrees'));
            } else {
                return redirect()->route('users-dependents')->with('error', 'Registro não encontrado!');
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
    public function store(UserDependentRequest $request, $pid)
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

            $user_dependent = UserDependent::create($request->all());
            return redirect()->route('users-dependents.show', ['pid' => $pid, 'id' => $user_dependent->id_user_dependent])->with('success', 'Registro cadastrado com sucesso');
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
            $data = UserDependent::user($pid)->find($id);
            if ($data) {
                $relationships_degrees = RelationshipDegree::all();
                return view('users.dependents.index', compact('pid', 'data', 'user', 'relationships_degrees'));
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
    public function update(UserDependentRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserDependentRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_dependent = UserDependent::user($pid)->find($id);
                if ($user_dependent) {
                    $user_dependent->update($request->all());
                    return redirect()->route('users-dependents.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('users-dependents')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-dependents')->with('error', 'Registro não encontrado!');
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
                $user_dependent = UserDependent::user($pid)->find($id);
                if ($user_dependent) {
                    $user_dependent->delete();
                    return redirect()->route('users-dependents.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('users-dependents.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-dependents.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        return DataTableHelper::users_dependents(UserDependent::user(request('pid')));
    }
}
