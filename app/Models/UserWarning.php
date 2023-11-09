<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserWarning extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_warnings';
    protected $primaryKey = 'id_user_warning';

    protected $fillable = [
        'id_user',
        'date',
        'description',
    ];
}
