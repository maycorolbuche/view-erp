<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserDependent extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_dependents';
    protected $primaryKey = 'id_user_dependent';

    protected $fillable = [
        'id_user',
        'id_carrier',
        'id_phone_type',
        'phone',
        'contact_name',
        'is_business',
        'has_whatsapp',
        'notes',
    ];

}
