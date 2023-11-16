<?php

namespace App\Helpers;

use App\Models\AuthorizationType;
use App\Models\UserAuthorizationType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Authorization
{

    public static function users($type, $id_user = null)
    {
        $authorization_type = AuthorizationType::where('type', $type)->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        if (count($authorization_type) > 0) {
            $id_authorization_type = $authorization_type[0];
            if ($id_user == null) {
                $id_user = Auth::id();
            }

            $users_authorizations_types = UserAuthorizationType::where([
                'id_authorization_type' => $id_authorization_type,
                'id_user_child' => $id_user
            ])->distinct()->pluck('id_user_parent')->toArray();

            if (count($users_authorizations_types) > 0) {
                $users = User::whereIn('id_user', $users_authorizations_types)->get();
                return $users->toArray();
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}
