<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    public function install()
    {
        Artisan::call('migrate');

        $output = Artisan::output();

        return response($output)->header('Content-Type', 'text/plain');
    }
}
