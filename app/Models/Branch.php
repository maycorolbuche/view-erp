<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';
    protected $primaryKey = 'id_branch';

    protected $fillable = [
        'name',
        'abbreviation',
        'zip_code',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
    ];
}
