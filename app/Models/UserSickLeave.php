<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserSickLeave extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_sick_leaves';
    protected $primaryKey = 'id_user_sick_leave';

    protected $fillable = [
        'id_user',
        'start_date',
        'end_date',
        'description',
    ];
}
