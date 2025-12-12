<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserPension extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_pensions';
    protected $primaryKey = 'id_user_pension';

    protected $fillable = [
        'id_user',
        'date',
    ];

    public function scopeUser($query, $id_user)
    {
        return $query->where('id_user', $id_user);
    }
}
