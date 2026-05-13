<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Route;

class Access
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
        $current_route = explode(".", \Route::currentRouteName() ?? '');

        $id_system = ($request->input('__id_system'));
        $route = Route::where('name', $current_route[0])->first();

        $res = $current_route[1] ?? '';

        if ($res == "datatable") {
            return $next($request);
        }

        if (!isset($request['__permissions_list'][$route->name])) {
            return response()->view('errors.unauthorized', [], 403);
        }

        $request->merge(['__route' => $route->toArray()]);
        $request->merge(['__permissions_page' => $request['__permissions_list'][$route->name]]);

        $id_route = $route['id_route'];

        //Verifica se tem permissão para acessar esta rota
        $access = auth()->user()->load(['permissions' => function ($query) use ($id_route, $id_system) {
            $query->where('id_route', $id_route)->where('id_system', $id_system);
        }])['permissions'];

        if (count($access) <= 0) {


            //Verifica se o(s) perfil(s) tem permissão para acessar esta rota
            $access = auth()->user()->load(['profiles' => function ($query) use ($id_route, $id_system) {
                $query->where('id_system', $id_system)->whereHas('permissions', function ($subquery) use ($id_route, $id_system) {
                    $subquery->where('id_route', $id_route)->where('id_system', $id_system);
                })->with(['permissions' => function ($subquery) use ($id_route, $id_system) {
                    $subquery->where('id_route', $id_route)->where('id_system', $id_system);
                }]);
            }])['profiles'];

            if (count($access) <= 0) {
                return response()->view('errors.unauthorized', [], 403);
            } else {
                $request->merge(['__authorization' => 'profile']);
                $request->merge(['__profile_authorization' => $access[0]["id_profile"]]);
            }
        } else {
            $request->merge(['__authorization' => 'user']);
        }

        return $next($request);
    }
}
