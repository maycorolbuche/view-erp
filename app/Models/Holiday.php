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
        'easter',
        'name',
    ];

    public function getDateAttribute()
    {

        if ($this->easter !== null) {
            $easterTimestamp = easter_date();
            $date = $easterTimestamp + ($this->easter * 24 * 60 * 60);
            return date("Y-m-d", $date);
        } else {
            return ($this->year ?? date("Y")) . "-" . $this->month . "-" . $this->day;
        }
    }

    public function getTypeAttribute()
    {
        return $this->easter !== null ? "easter" : ($this->year == null ? "repeat" : "unique");
    }

    public function holidays_branches()
    {
        return $this->hasMany(HolidayBranch::class, 'id_holiday', 'id_holiday');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, HolidayBranch::class, 'id_holiday', 'id_branch');
    }
}
