<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Authorization extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations';
    protected $primaryKey = 'id_authorization';

    protected $fillable = [
        'id_user',
        'id_authorization_type',
        'description',
        'start_datetime',
        'end_datetime',
        'self',
        'active',
        'approved',
    ];
}
