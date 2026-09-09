<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserPhone extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_phones';
    protected $primaryKey = 'id_user_phone';

    protected $fillable = [
        'id_user',
        'id_carrier',
        'id_phone_type',
        'phone',
        'contact_name',
        'is_business',
        'has_whatsapp',
        'notes',
    ];


    public function carrier(): HasOne
    {
        return $this->hasOne(Carrier::class, 'id_carrier', 'id_carrier');
    }

    public function phone_type(): HasOne
    {
        return $this->hasOne(PhoneType::class, 'id_phone_type', 'id_phone_type');
    }

    public function scopeUser(Builder $query, int|string $id_user): Builder
    {
        return $query->where('id_user', $id_user);
    }
}
