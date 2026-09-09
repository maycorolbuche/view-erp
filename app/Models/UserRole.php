<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserRole extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_roles';
    protected $primaryKey = 'id_user_role';

    protected $fillable = [
        'id_user',
        'id_role',
        'start_date',
        'end_date',
    ];

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }

    public function scopeUser(Builder $query, int|string $id_user): Builder
    {
        return $query->where('id_user', $id_user);
    }
}
