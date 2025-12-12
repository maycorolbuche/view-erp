<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserCertification extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_certifications';
    protected $primaryKey = 'id_user_certification';

    protected $fillable = [
        'id_user',
        'start_date',
        'end_date',
        'description',
    ];

    public function scopeUser($query, $id_user)
    {
        return $query->where('id_user', $id_user);
    }
}
