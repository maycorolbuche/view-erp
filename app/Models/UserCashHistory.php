<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserCashHistory extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_cash_history';
    protected $primaryKey = 'id_user_cash_history';

    protected $fillable = [
        'id_transaction',
        'id_authorization',
        'id_batch',
        'id_user',
        'amount',
        'previous_balance',
        'current_balance',
    ];
}
