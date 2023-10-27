<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserSystem extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_systems';
    protected $primaryKey = 'id_user_system';

    protected $fillable = [
        'id_user',
        'id_system',
    ];
}
