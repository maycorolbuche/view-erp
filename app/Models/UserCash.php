<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserCash extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_cash';
    protected $primaryKey = 'id_user_cash';

    protected $fillable = [
        'id_user',
        'amount',
    ];
}
