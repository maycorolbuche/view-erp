<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class AuthorizationType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations_types';
    protected $primaryKey = 'id_authorization_type';

    protected $fillable = [
        'name',
        'approval',
        'sequence',
    ];
}
