<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Helpers\AuthorizationHelper;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $permissions = request('__permissions_list');
        $pages = request('__permissions');
        $user = Auth::user();

        $authorizations_pending_count = AuthorizationHelper::pending_count();

        $batch_review_count = Batch::reviewPending()->whereNull('revised_by')->count();
        $batch_payments_count = Batch::paymentPending()->count();

        return view('dashboard.index', compact('permissions', 'batch_review_count', 'batch_payments_count', 'authorizations_pending_count', 'pages', 'user'));
    }
}
