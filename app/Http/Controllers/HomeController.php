<?php

namespace App\Http\Controllers;

use App\Helpers\Permissions;

class HomeController extends Controller
{
    public function index()
    {
        
        $systems = Permissions::systems();
        if ($systems == null || count($systems) <= 0) {
            return view('errors.systems');
        } elseif (count($systems) == 1) {
            return redirect('/' . $systems[0]["slug"]);
        } else {
            return view('root.index', compact("systems"));
        }
    }
    public function dashboard()
    {

        return view('welcome');
    }
}
