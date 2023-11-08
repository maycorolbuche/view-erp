<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Carrier extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'carriers';
    protected $primaryKey = 'id_carrier';

    protected $fillable = [
        'name',
    ];
}
