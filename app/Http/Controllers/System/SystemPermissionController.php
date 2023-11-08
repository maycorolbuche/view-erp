<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\Permission;
use App\Models\RouteGroup;
use Illuminate\Http\Request;
use App\Helpers\Root;

class SystemPermissionController extends Controller
{
    public function parent()
    {
        return view('systems.permissions.parent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $system = System::find($id);
        if (!$system) {
            return redirect()->route('profiles-permissions')->with('error', 'Registro não encontrado!');
        }

        $routes = RouteGroup::orderBy('sequence')->with(['routes' => function ($query) {
            $query->orderBy('sequence');
        }])->get();
        $permissions = Permission::where('id_system', $id)->whereNull('id_user')->whereNull('id_profile')->get()->keyBy('id_route');

        $pid = $id;

        return view('systems.permissions.index', compact('pid', 'system', 'routes', 'permissions'));
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
            $system = System::find($id);
            if ($system) {
                Permission::where('id_system', $id)->whereNull('id_user')->whereNull('id_profile')->delete();
                if (isset($request->route)) {
                    foreach ($request->route as $id_route => $value) {
                        $data = [];
                        $data['id_system'] = $id;
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
                return redirect()->route('systems-permissions.index', ['pid' => $system->id_system])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('systems')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
