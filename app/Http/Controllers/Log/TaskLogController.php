<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\TaskLog;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\ConfigHelper as Configs;

class TaskLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TaskLog::whereIn('id_task_log', function ($query) {
            $query->select(DB::raw('MAX(id_task_log)'))
                ->from('task_logs')
                ->groupBy('signature');
        })
            ->orderByDesc('id_task_log');

        $last_start = Configs::get("cron.run.start");
        $last_end = Configs::get("cron.run.end");

        return view('task-logs.index', compact('data', 'last_start', 'last_end'));
    }

    public function datatable()
    {
        return DataTableHelper::task_logs();
    }
}
