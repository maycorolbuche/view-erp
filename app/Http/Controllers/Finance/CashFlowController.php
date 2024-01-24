<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Helpers\DataTableHelper;

class CashFlowController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash-flow.index');
    }


    public function datatable()
    {
        return DataTableHelper::transactions();
    }
}
