<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
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

    public function discount(): HasOne
    {
        return $this->hasOne(Discount::class, 'id_discount', 'id_discount');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function scopeUser(Builder $query, int|string $id_user): Builder
    {
        return $query->where('id_user', $id_user);
    }
}
