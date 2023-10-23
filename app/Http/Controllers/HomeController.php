<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (count($systems) <= 0) {
            return view('errors.systems');
        } elseif (count($systems) == 1) {
            return redirect('/' . $systems[0]["slug"]);
        } else {
            return view('root.index');
        }
    }
    public function dashboard()
    {
        return view('welcome');
    }
}
