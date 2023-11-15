<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class TransactionType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'transactions_types';
    protected $primaryKey = 'id_transaction_type';

    protected $fillable = [
        'name',
    ];
}
