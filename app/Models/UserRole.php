<?php

namespace App\Models;

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

    protected $casts = [
        'start_date' => 'date:d/m/Y',
        'end_date' => 'date:d/m/Y',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }
}
