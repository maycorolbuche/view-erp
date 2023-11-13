<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Holiday extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'holidays';
    protected $primaryKey = 'id_holiday';

    protected $fillable = [
        'year',
        'month',
        'day',
        'name',
    ];

    public function getDateAttribute()
    {
        return ($this->year ?? date("Y")) . "-" . $this->month . "-" . $this->day;
    }

    public function getRepeatAttribute()
    {
        return $this->year == null;
    }

    public function holidays_branches()
    {
        return $this->hasMany(HolidayBranch::class, 'id_holiday', 'id_holiday');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, HolidayBranch::class, 'id_holiday', 'id_holiday');
    }
}
