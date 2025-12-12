<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserVacation extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_vacations';
    protected $primaryKey = 'id_user_vacation';

    protected $fillable = [
        'id_user',
        'start_date_acquisition_period',
        'end_date_acquisition_period',
        'start_date_requested_period',
        'end_date_requested_period',
        'start_date_approval_period',
        'end_date_approval_period',
        'start_date_approved_period',
        'end_date_approved_period',
        'start_date',
        'end_date',
    ];

    public function scopeUser($query, $id_user)
    {
        return $query->where('id_user', $id_user);
    }
}
