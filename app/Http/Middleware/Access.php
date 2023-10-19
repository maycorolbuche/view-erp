<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $path = explode("/", $request->path());

        $id_system = ($request->input('__id_system'));


        //Verifica se tem permissão para acessar esta rota
        $access = Auth::user()->load(['permissions' => function ($query) use ($path, $id_system) {
            $query->where('route', $path[1] ?? '')->where('id_system', $id_system);
        }])['permissions'];

        if (count($access) <= 0) {


            //Verifica se o(s) perfil(s) tem permissão para acessar esta rota
            $access = Auth::user()->load(['profiles' => function ($query) use ($path, $id_system) {
                $query->where('id_system', $id_system)->whereHas('permissions', function ($subquery) use ($path, $id_system) {
                    $subquery->where('route', $path[1] ?? '')->where('id_system', $id_system);
                })->with(['permissions' => function ($subquery) use ($path, $id_system) {
                    $subquery->where('route', $path[1] ?? '')->where('id_system', $id_system);
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
