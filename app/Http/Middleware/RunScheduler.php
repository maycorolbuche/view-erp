<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class RunScheduler
{
    public function handle($request, Closure $next)
    {
        // Evita rodar mais de uma vez por minuto
        $executed = Cache::get('scheduler_last_run');

        if (!$executed || now()->diffInSeconds($executed) >= 60) {
            // Marca horário da execução
            Cache::put('scheduler_last_run', now());

            // Executa o schedule
            Artisan::call('schedule:run');
        }

        return $next($request);
    }
}
