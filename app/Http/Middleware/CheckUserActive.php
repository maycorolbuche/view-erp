<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->active) {
            Auth::logout();

            return redirect('/login')->withErrors([
                'message' => 'Seu usuário está inativo.'
            ]);
        }

        return $next($request);
    }
}
