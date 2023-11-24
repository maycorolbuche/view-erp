<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Permission;
use App\Models\RouteGroup;
use Illuminate\Http\Request;
use App\Helpers\RootHelper as Root;

class ProfilePermissionController extends Controller
{
    public function parent()
    {
        return view('profiles.permissions.parent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id_system = request('__id_system');
        $profile = Profile::find($id);
        if (!$profile) {
            return redirect()->route('profiles-permissions')->with('error', 'Registro não encontrado!');
        }

        $routes = RouteGroup::orderBy('sequence')->with(['routes' => function ($query) use ($id_system) {
            $query->select([
                "id_route", "id_route_group", "label", "name", "uri", "controller", "resources", "icon", "sequence", "root"
            ])->with(['permissions' => function ($subquery) use ($id_system) {
                $subquery->where('id_system', $id_system)->whereNull('id_user')->whereNull('id_profile');
            }])->whereHas('permissions', function ($subquery) use ($id_system) {
                $subquery->where('id_system', $id_system)->whereNull('id_user')->whereNull('id_profile');
            })->orderBy('sequence');
        }])->whereHas('routes', function ($query) use ($id_system) {
            $query->whereHas('permissions', function ($subquery) use ($id_system) {
                $subquery->where('id_system', $id_system)->whereNull('id_user')->whereNull('id_profile');
            });
        })->get();

        $permissions = Permission::where(['id_system' => $id_system, 'id_profile' => $id])->whereNull('id_user')->get()->keyBy('id_route');;

        $pid = $id;

        return view('profiles.permissions.index', compact('pid', 'profile', 'routes', 'permissions'));
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
        $id_system = request('__id_system');

        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $profile = Profile::find($id);
            if ($profile) {
                Permission::where('id_system', $id_system)->where('id_profile', $id)->delete();
                if (isset($request->route)) {
                    foreach ($request->route as $id_route => $value) {
                        $data = [];
                        $data['id_system'] = $id_system;
                        $data['id_profile'] = $id;
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
                return redirect()->route('profiles-permissions.index', ['pid' => $profile->id_profile])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('profiles')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
