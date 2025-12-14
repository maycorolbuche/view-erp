<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Helpers\DataTableHelper;

class NotificationLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notification-logs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = NotificationLog::find($id);
        if ($data) {
            return view('notification-logs.index', compact('data'));
        } else {
            return redirect()->route('notification-logs')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        return DataTableHelper::notification_logs();
    }
}
