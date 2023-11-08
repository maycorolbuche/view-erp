<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Role extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'name',
    ];
}
