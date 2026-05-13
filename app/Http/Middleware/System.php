<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Authorization;

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
        $path = explode("/", $request->path());
        $system = $path[0];


        //Verifica se tem permissão para acessar este sistema
        $access = auth()->user()->load(
            ['systems' => function ($query) use ($system) {
                $query->where('slug', $system);
            }]
        )['systems'];

        if (count($access) <= 0) {
            return response()->view('errors.404', [], 404);
        }

        $id_system = $access[0]['id_system'];
        $request->merge(['__id_system' => $id_system]);
        $request->merge(['__system' => $access[0]->toArray()]);

        $permissions = auth()->user()->load('permissions.route.route_group')['permissions']->toArray();

        foreach (auth()->user()->load('profiles.permissions.route.route_group')["profiles"] as $profile) {
            $permissions = array_merge($permissions, $profile->permissions->toArray());
        }

        $permissions_list = [];
        $permissions_group = [];
        foreach ($permissions as $permission) {
            if ($permission['id_system'] <> $id_system) {
                continue;
            }
            $n01 = str_pad($permission['route']['route_group']['sequence'], 6, '0', STR_PAD_LEFT)
                . '-' . $permission['route']['route_group']['id_route_group'];
            $n02 = str_pad($permission['route']['sequence'], 6, '0', STR_PAD_LEFT)
                . '-' . $permission['route']['id_route'];

            $permissions_group[$n01]["label"] = $permission['route']['route_group']["label"];
            $permissions_group[$n01]["icon"] = $permission['route']['route_group']["icon"];
            $permissions_group[$n01]["items"][$n02] = $permission;
            ksort($permissions_group[$n01]["items"]);

            $permissions_list[$permission['route']['name']] = array_merge($permissions_list[$permission['route']['name']] ?? [], $permission["permissions"]);
        }
        ksort($permissions_group);

        $request->merge(['__permissions' => $permissions_group]);
        $request->merge(['__permissions_list' => $permissions_list]);

        $request->merge(['__count_authorization' => Authorization::getPendingResponseCount()]);

        return $next($request);
    }
}
