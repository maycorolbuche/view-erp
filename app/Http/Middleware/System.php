<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class System
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $system = $request->route('system');


        //Verifica se tem permissão para acessar este sistema
        $access = Auth::user()->load(
            ['systems' => function ($query) use ($system) {
                $query->where('slug', $system);
            }]
        )['systems'];

        if (count($access) <= 0) {
            return response()->view('errors.system_not_found', [], 403);
        }

        $id_system = $access[0]['id_system'];
        $request->merge(['__id_system' => $id_system]);
        $request->merge(['__system' => $access[0]['name']]);
        $request->merge(['__system_icon' => $access[0]['icon']]);

        $permissions = Auth::user()->load(
            ['permissions' => function ($query) use ($id_system) {
                $query->where('id_system', $id_system)->with(['route' => function ($subquery) {
                    $subquery->with('route_group');
                }]);
            }]
        )['permissions']->toArray();

        $permissions_group = [];
        foreach ($permissions as $permission) {
            $n01 = str_pad($permission['route']['route_group']['sequence'], 6, '0', STR_PAD_LEFT)
                . '-' . $permission['route']['route_group']['id_route_group'];
            $n02 = str_pad($permission['route']['sequence'], 6, '0', STR_PAD_LEFT)
                . '-' . $permission['route']['id_route'];

            $permissions_group[$n01]["label"] = $permission['route']['route_group']["label"];
            $permissions_group[$n01]["icon"] = $permission['route']['route_group']["icon"];
            $permissions_group[$n01]["items"][$n02] = $permission;
            ksort($permissions_group[$n01]["items"]);
        }

        ksort($permissions_group);

        $request->merge(['__permissions' => $permissions_group]);

        return $next($request);
    }
}
