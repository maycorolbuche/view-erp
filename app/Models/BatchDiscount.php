<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class BatchDiscount extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'batches_discounts';
    protected $primaryKey = 'id_batch_discount';

    protected $fillable = [
        'id_batch',
        'id_expense',
        'id_discount',
        'expense_amount',
        'expense_amount_prev',
        'amount',
        'expense_amount_cur',
        'ref_amount',
        'ref_date',
        'sequence',
    ];
}
