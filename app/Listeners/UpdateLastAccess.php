<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Session;

class UpdateLastAccess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        if (!Session::has('last_login')) {
            auth()->user()->updateLastAccess();
            Session::put('last_login', now());
        }
    }
}
