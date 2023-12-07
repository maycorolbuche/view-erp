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
}
