<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class DiscountAmount extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'discounts_amounts';
    protected $primaryKey = 'id_discount_amount';

    protected $fillable = [
        'id_discount',
        'date',
        'amount',
    ];
}
