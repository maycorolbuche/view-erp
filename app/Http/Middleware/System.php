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
                $query->where('id_system', $id_system);
            }]
        )['permissions']->keyBy('id_route')->toArray();
        $request->merge(['__permissions' => $permissions]);

        return $next($request);
    }
}
