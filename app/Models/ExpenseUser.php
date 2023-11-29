<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class ExpenseUser extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses_users';
    protected $primaryKey = 'id_expense_user';

    protected $fillable = [
        'id_expense',
        'id_user',
        'amount',
        'percentage',
    ];
}
