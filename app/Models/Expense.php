<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Expense extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses';
    protected $primaryKey = 'id_expense';

    protected $fillable = [
        'id_authorization',
        'id_user',
        'id_batch',
        'date',
        'id_category',
        'id_payment_method',
        'amount',
        'notes',
    ];

    public function authorization()
    {
        return $this->hasOne(Authorization::class, 'id_authorization', 'id_authorization');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }

    public function payment_method()
    {
        return $this->hasOne(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }
}
