<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Config extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'configs';
    protected $primaryKey = 'id_config';

    protected $fillable = [
        'key',
        'value',
    ];
}
