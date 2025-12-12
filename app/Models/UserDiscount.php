<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserDiscount extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_discounts';
    protected $primaryKey = 'id_user_discount';

    protected $fillable = [
        'id_user',
        'id_discount',
    ];

    public function discount()
    {
        return $this->hasOne(Discount::class, 'id_discount', 'id_discount');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function scopeUser($query, $id_user)
    {
        return $query->where('id_user', $id_user);
    }
}
