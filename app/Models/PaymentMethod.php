<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class PaymentMethod extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'payment_methods';
    protected $primaryKey = 'id_payment_method';

    protected $fillable = [
        'name',
        'refundable',
    ];
}
