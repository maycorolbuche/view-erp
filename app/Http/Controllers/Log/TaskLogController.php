<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\TaskLog;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\DB;

class TaskLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestLogs = TaskLog::whereIn('id_task_log', function ($query) {
            $query->select(DB::raw('MAX(id_task_log)'))
                ->from('task_logs')
                ->groupBy('signature');
        })
            ->orderByDesc('id_task_log');

        return view('task-logs.index', ['data' => $latestLogs]);
    }

    public function datatable()
    {
        return DataTableHelper::task_logs();
    }
}
