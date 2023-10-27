<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CivilStatus extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'civil_statuses';
    protected $primaryKey = 'id_civil_status';

    protected $fillable = [
        'description',
    ];
}
