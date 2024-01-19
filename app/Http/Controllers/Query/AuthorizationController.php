<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Helpers\DataTableHelper;

class AuthorizationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('queries.authorizations');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Authorization::with(['statuses', 'authorization_parent'])->find($id);
        if ($data) {
            return view('queries.authorizations', compact('data'));
        } else {
            return redirect()->route('queries-authorizations')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        return DataTableHelper::authorizations();
    }
}
