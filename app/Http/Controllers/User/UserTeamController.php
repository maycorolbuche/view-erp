<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTeam;
use App\Models\AuthorizationType;
use App\Models\UserAuthorizationType;
use App\Helpers\DataTableHelper;
use App\Http\Requests\UserTeamRequest;

class UserTeamController extends Controller
{
    public function parent()
    {
        return view('users.teams.parent');
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
                $users = User::all();
                $authorizations_types = AuthorizationType::orderBy('sequence')->get();
                return view('users.teams.index', compact('pid', 'user', 'users', 'authorizations_types'));
            } else {
                return redirect()->route('users-teams')->with('error', 'Registro não encontrado!');
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
    public function store(UserTeamRequest $request, $pid)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        if ($pid == $request->id_user_people) {
            return redirect()->back()->with('error', 'Não é possível inserir a pessoa em sua própria equipe!')->withInput();
        }

        if ($request->relationship == "parent") {
            $request->merge(['id_user_child' => $pid]);
            $request->merge(['id_user_parent' => $request->id_user_people]);
        } else {
            $request->merge(['id_user_parent' => $pid]);
            $request->merge(['id_user_child' => $request->id_user_people]);
        }

        $request->merge(['authorizations' => array_keys($request->authorizations ?? [])]);

        try {
            $user = User::find($pid);
            if (!$user) {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }

            $user_team = UserTeam::where(['id_user_parent' => $request->id_user_parent, 'id_user_child' => $request->id_user_child])->first();
            if ($user_team) {
                return redirect()->back()->with('error', 'Já existe um registro com esta pessoa!')->withInput();
            }

            $user_team = UserTeam::create($request->all());
            $this->UsersAuthorizationsTypes($user_team->id_user_team, $request->id_authorization_type ?? []);
            return redirect()->route('users-teams.show', ['pid' => $pid, 'id' => $user_team->id_user_team])->with('success', 'Registro cadastrado com sucesso');
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
            $data = UserTeam::find($id);
            if ($data) {
                $users = User::all();
                $authorizations_types = AuthorizationType::orderBy('sequence')->get();

                if ($data->id_user_parent == $pid) {
                    $data->id_user_people = $data->id_user_child;
                    $data->relationship = "child";
                } else {
                    $data->id_user_people = $data->id_user_parent;
                    $data->relationship = "parent";
                }

                return view('users.teams.index', compact('pid', 'data', 'user', 'users', 'authorizations_types'));
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
    public function update(UserTeamRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserTeamRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        if ($pid == $request->id_user_people) {
            return redirect()->back()->with('error', 'Não é possível inserir a pessoa em sua própria equipe!')->withInput();
        }

        if ($request->relationship == "parent") {
            $request->merge(['id_user_child' => $pid]);
            $request->merge(['id_user_parent' => $request->id_user_people]);
        } else {
            $request->merge(['id_user_parent' => $pid]);
            $request->merge(['id_user_child' => $request->id_user_people]);
        }

        if ($request->relationship_old == "parent") {
            $request->merge(['id_user_child_old' => $pid]);
            $request->merge(['id_user_parent_old' => $request->id_user_people_old]);
        } else {
            $request->merge(['id_user_parent_old' => $pid]);
            $request->merge(['id_user_child_old' => $request->id_user_people_old]);
        }

        $request->merge(['authorizations' => array_keys($request->authorizations ?? [])]);

        try {
            $user = User::find($pid);
            if ($user) {
                $user_team = UserTeam::where(['id_user_parent' => $request->id_user_parent, 'id_user_child' => $request->id_user_child])->whereNotIn('id_user_team', [$id])->first();
                if ($user_team) {
                    return redirect()->back()->with('error', 'Já existe um registro com esta pessoa!')->withInput();
                }

                $user_team = UserTeam::find($id);
                if ($user_team) {
                    $user_team->update($request->all());

                    $this->UsersAuthorizationsTypes($user_team->id_user_team, $request->id_authorization_type ?? []);
                    return redirect()->route('users-teams.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('users-teams')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-teams')->with('error', 'Registro não encontrado!');
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
                $user_team = UserTeam::find($id);
                if ($user_team) {
                    $user_team->delete();
                    return redirect()->route('users-teams.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('users-teams.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-teams.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        return DataTableHelper::users_teams(UserTeam::user(request('pid')));
    }


    public function UsersAuthorizationsTypes($id_user_team, $authorizations_types)
    {
        $data = UserTeam::find($id_user_team);
        UserAuthorizationType::where('id_user_team', $id_user_team)->delete();
        if ($authorizations_types && count($authorizations_types) > 0) {
            foreach (array_keys($authorizations_types) as $id_authorization_type) {
                UserAuthorizationType::create([
                    'id_user_team' =>  $id_user_team,
                    'id_user_parent' =>  $data->id_user_parent,
                    'id_user_child' =>  $data->id_user_child,
                    'id_authorization_type' => $id_authorization_type
                ]);
            }
        }
    }
}
