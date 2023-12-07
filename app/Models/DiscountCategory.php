<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class DiscountCategory extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'discounts_categories';
    protected $primaryKey = 'id_discount_category';

    protected $fillable = [
        'id_discount',
        'id_category',
    ];
}
