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
        // Verificação opcional de segurança via token
        /*if ($request->token !== env('SCHEDULE_TOKEN')) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }*/

        // Executa o scheduler
        Artisan::call('schedule:run');
        $output = Artisan::output();

        return response()->json([
            'status' => 'ok',
            'output' => $output
        ]);
    }
}
