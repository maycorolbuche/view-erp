<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\System;
use App\Models\UserSystem;

class Permissions
{

    public static function systems($id_user = null)
    {
        if ($id_user == null) {
            $id_user = Auth::user()->id_user;
        }

        $user = User::with('systems')->find($id_user);
        if ($user == null) {
            return null;
        }

        if ($user->root == 1) {
            $systems = System::all();
        } else {
            $systems = $user->systems;
        }

        return $systems->toArray();
    }

    public static function system($id_system, $id_user = null)
    {
        if ($id_user == null) {
            $id_user = Auth::user()->id_user;
        }

        $user = User::with('systems')->find($id_user);
        

        if (!is_numeric($id_system)) {
            $system = System::select('id_system')->where('slug', $id_system)->first();
            if ($system == null) {
                return false;
            }

            if ($user->root == 1) {
                return true;
            }
            $id_system = $system->toArray()['id_system'];
        }

        if ($user->root == 1) {
            $system = System::select('id_system')->where('id_system', $id_system)->first();
            return !($system == null);
        }

        $access = UserSystem::where(['id_user' => $id_user, 'id_system' => $id_system])->first();
        return !($access == null);
    }
}
