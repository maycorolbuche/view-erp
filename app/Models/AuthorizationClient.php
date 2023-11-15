<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class AuthorizationClient extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations_clients';
    protected $primaryKey = 'id_authorization_client';

    protected $fillable = [
        'id_authorization',
        'id_client',
    ];
}
