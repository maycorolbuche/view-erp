<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use App\Models\RouteGroup;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Helpers\RootHelper as Root;

class UserPermissionController extends Controller
{
    public function parent()
    {
        return view('users.permissions.parent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users-permissions')->with('error', 'Registro não encontrado!');
        }

        $routes = RouteGroup::orderBy('sequence')->with(['routes' => function ($query) {
            $query->select([
                "id_route", "id_route_group", "label", "name", "uri", "controller", "resources", "icon", "sequence", "root"
            ])->with(['permissions' => function ($subquery) {
                $subquery->whereNull('id_user')->whereNull('id_profile');
            }])->whereHas('permissions', function ($subquery) {
                $subquery->whereNull('id_user')->whereNull('id_profile');
            })->orderBy('sequence');
        }])->whereHas('routes', function ($query) {
            $query->whereHas('permissions', function ($subquery) {
                $subquery->whereNull('id_user')->whereNull('id_profile');
            });
        })->get();

        $permissions = Permission::where('id_user', $id)->whereNull('id_profile')->get()->keyBy('id_route');

        $profiles = UserProfile::where(['id_user' => $id])->pluck('id_profile')->toArray();
        $permissions_profiles = Permission::whereIn('id_profile', $profiles)->whereNull('id_user')->with('profile')->get();

        $group_permissions = [];
        foreach ($permissions_profiles as $permission) {
            $group_permissions[$permission->id_route][$permission->id_profile] = $permission->toArray();
        }
        $permissions_profiles = $group_permissions;

        $pid = $id;

        return view('users.permissions.index', compact('pid', 'user', 'routes', 'permissions', 'permissions_profiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {
                Permission::where('id_user', $id)->delete();
                if (isset($request->route)) {
                    foreach ($request->route as $id_route => $value) {
                        $data = [];
                        $data['id_user'] = $id;
                        $data['id_route'] = $id_route;

                        $perm = [];
                        if (isset($request['store'][$id_route])) {
                            $perm[] = "store";
                        }
                        if (isset($request['update'][$id_route])) {
                            $perm[] = "update";
                        }
                        if (isset($request['destroy'][$id_route])) {
                            $perm[] = "destroy";
                        }

                        $data['permissions'] = $perm;

                        Permission::create($data);
                    }
                }
                Root::run();
                return redirect()->route('users-permissions.index', ['pid' => $user->id_user])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Não foi possível concluir a operação. Tente novamente ou contate o suporte.')->withInput();
        }
    }
}
