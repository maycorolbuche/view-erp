<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class EmploymentType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'employment_types';
    protected $primaryKey = 'id_employment_type';

    protected $fillable = [
        'description',
    ];
}
