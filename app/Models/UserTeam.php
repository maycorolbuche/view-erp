<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserTeam extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_teams';
    protected $primaryKey = 'id_user_team';

    protected $fillable = [
        'id_user_parent',
        'id_user_child',
        'authorizations',
    ];

    protected $casts = [
        'authorizations' => 'array',
    ];


    public function parent()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_parent');
    }

    public function child()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_child');
    }
}
