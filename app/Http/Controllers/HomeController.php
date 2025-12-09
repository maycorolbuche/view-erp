<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Batch;
use App\Helpers\AuthorizationHelper;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $systems = Auth::user()->load('systems')['systems']->toArray();
        if (count($systems) <= 0) {
            return view('errors.systems');
        } elseif (count($systems) == 1) {
            return redirect('/' . $systems[0]["slug"]);
        } else {
            return view('root.index', compact("systems"));
        }
    }
    public function dashboard()
    {
        $id_system = request('__id_system');
        $system = System::find($id_system);
        $permissions = request('__permissions_list');
        $pages = request('__permissions');
        $user = Auth::user();

        $authorizations_pending_count = AuthorizationHelper::pending_count();

        $batch_review_count = Batch::where('active', true)->whereIn('revised_status',  ['pending', 'analyzing'])->count();
        $batch_payments_count = Batch::where(['active' => true, 'revised_status' => 'approved'])->count();

        return view('dashboard.index', compact('system', 'permissions', 'batch_review_count', 'batch_payments_count', 'authorizations_pending_count', 'pages', 'user'));
    }
}
