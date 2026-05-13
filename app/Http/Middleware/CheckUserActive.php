<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserActive
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && !$user->active) {
            auth()->logout();

            return redirect('/login')->withErrors([
                'message' => 'Seu usuário está inativo.'
            ]);
        }

        return $next($request);
    }
}
