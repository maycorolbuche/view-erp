<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Helpers\DataTableHelper;

class UserSearchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search.users');
    }

    public function datatable()
    {
        return DataTableHelper::users();
    }
}
