<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Branch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'branches';
    protected $primaryKey = 'id_branch';

    protected $fillable = [
        'name',
        'short_name',
        'zip_code',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
    ];
}
