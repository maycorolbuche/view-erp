<?php

namespace App\Http\Controllers;

use App\Helpers\BirthdayHelper;
use Illuminate\Contracts\View\View;

class BirthdayController extends Controller
{
    public function index(): View
    {
        $users = BirthdayHelper::users();

        return view('birthdays.index', [
            'months' => BirthdayHelper::MONTHS,
            'birthdaysByMonth' => $users->whereNotNull('month')->sortBy('day')->groupBy('month'),
        ]);
    }
}
