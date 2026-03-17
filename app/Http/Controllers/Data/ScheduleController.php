<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ScheduleController extends Controller
{
    /**
     * Executa o schedule:run manualmente.
     */
    public function run(Request $request)
    {
        // Lista as tasks
        Artisan::call('schedule:list');
        $tasks = Artisan::output();

        // Executa o scheduler
        Artisan::call('schedule:run');
        $execution = Artisan::output();

        $output = "=== SCHEDULE LIST ===\n";
        $output .= $tasks . "\n";
        $output .= "=== EXECUTION ===\n";
        $output .= $execution;

        return response($output, 200)
            ->header('Content-Type', 'text/plain');
    }
}
