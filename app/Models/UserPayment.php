<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserPayment extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_payments';
    protected $primaryKey = 'id_user_payment';

    protected $fillable = [
        'id_user',
        'date',
        'amount',
        'description',
    ];
}
