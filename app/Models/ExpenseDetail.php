<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class ExpenseDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses_details';
    protected $primaryKey = 'id_expense_detail';

    protected $fillable = [
        'id_expense',
        'id_expense_user',
        'id_user',
        'id_expense_client',
        'id_client',
        'amount',
        'percentage',
    ];
}
