<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class AuthorizationStatus extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations_statuses';
    protected $primaryKey = 'id_authorization_status';

    protected $fillable = [
        'id_authorization',
        'id_user',
        'approved',
        'description',
    ];
}
