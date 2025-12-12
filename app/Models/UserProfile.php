<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserProfile extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_profiles';
    protected $primaryKey = 'id_user_profile';

    protected $fillable = [
        'id_user',
        'id_profile',
    ];

    public function scopeUser($query, $id_user)
    {
        return $query->where('id_user', $id_user);
    }
}
