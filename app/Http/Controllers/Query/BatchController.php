<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
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
        return view('queries.batches');
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
            return view('queries.batches', $data);
        } else {
            return redirect()->route('queries-batches')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        return DataTableHelper::batches();
    }
}
