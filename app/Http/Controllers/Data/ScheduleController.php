<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

class ScheduleController extends Controller
{
    /**
     * Executa o schedule:run manualmente.
     */
    public function run()
    {
        /*   $return = "";
        Artisan::call('schedule:run');
        $return .= "############## EXECUÇÃO DE JOBS ##############" . PHP_EOL;
        $return .= Artisan::output();

        Artisan::call('schedule:list');
        $return .= "############## JOBS AGENDADOS ##############" . PHP_EOL;
        $return .=  Artisan::output();

        return response($return, 200)
            ->header('Content-Type', 'text/plain');
            */

        // Inicializa o Kernel
        app(Kernel::class);

        // Obtém o scheduler
        $schedule = app(Schedule::class);

        $now = now()->format('i H * * *');

        $output = [];
        cache()->forget('cron_running');
        // evita concorrência
        if (!cache()->add(
            'cron_running',
            true,
            now()->addMinutes(10)
        )) {
            return response()->json([
                'status' => 'Já executando'
            ]);
        }

        try {
            foreach ($schedule->events() as $event) {
                // verifica se deve rodar AGORA
                if (!$event->isDue(app())) {
                    continue;
                }

                try {
                    // pega comando
                    $str = $event->command;
                    $parts = explode(" ", $str);
                    $command = end($parts);

                    Artisan::call($command);

                    $output[] = [
                        'command' => $command,
                        'status' => 'SUCCESS',
                        'output' => trim(Artisan::output()),
                    ];
                } catch (\Throwable $e) {
                    $output[] = [
                        'command' => $command ?? 'unknown',
                        'status' => 'FAIL',
                        'error' => $e->getMessage(),
                    ];
                }
            }
        } finally {
            cache()->forget('cron_running');
        }

        return response()->json([
            'time' => now()->format('Y-m-d H:i:s'),
            'tasks' => $output,
        ]);
    }

    public function list()
    {
        Artisan::call('schedule:list');
        $output =  Artisan::output();

        return response($output, 200)
            ->header('Content-Type', 'text/plain');
    }
}
