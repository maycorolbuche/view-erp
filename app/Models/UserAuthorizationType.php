<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserAuthorizationType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_authorizations_types';
    protected $primaryKey = 'id_user_authorization_type';

    protected $fillable = [
        'id_user_team',
        'id_user_parent',
        'id_user_child',
        'id_authorization_type',
    ];



    public function parent()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_parent');
    }

    public function child()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_child');
    }

    public function authorization_type()
    {
        return $this->hasOne(AuthorizationType::class, 'id_authorization_type', 'id_authorization_type');
    }
}
