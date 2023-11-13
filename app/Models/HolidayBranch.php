<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class HolidayBranch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'holidays_branches';
    protected $primaryKey = 'id_holiday_branch';

    protected $fillable = [
        'id_holiday',
        'id_branch',
    ];
}
