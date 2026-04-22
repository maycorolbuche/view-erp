<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\BatchHelper;
use App\Helpers\DataTableHelper;

class BatchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('queries.batches', compact('users'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = BatchHelper::data($id);
        if ($data) {
            $chart_categories = $data["chart_categories"];
            $chart_clients = $data["chart_clients"];
            $data = $data["data"];
            $users = User::orderBy('name')->get();
            return view('queries.batches', compact('data', 'users', 'chart_categories', 'chart_clients'));
        } else {
            return redirect()->route('queries-batches')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        return DataTableHelper::batches();
    }
}
