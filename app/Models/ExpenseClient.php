<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class ExpenseClient extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses_clients';
    protected $primaryKey = 'id_expense_client';

    protected $fillable = [
        'id_expense',
        'id_client',
        'amount',
        'percentage',
    ];
}
