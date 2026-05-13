<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class AuthorizationType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations_types';
    protected $primaryKey = 'id_authorization_type';

    protected $fillable = [
        'name',
        'type',
        'approval',
        'sequence',
    ];

    public static function getUsers(string $type, ?int $id_user = null)
    {
        $authorization_type = AuthorizationType::where('type', $type)->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        if (count($authorization_type) > 0) {
            $id_authorization_type = $authorization_type[0];
            if ($id_user == null) {
                $id_user = auth()->id();
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
