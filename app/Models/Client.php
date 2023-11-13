<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Client extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'clients';
    protected $primaryKey = 'id_client';

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
