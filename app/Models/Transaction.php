<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Transaction extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
        'type',
        'id_authorization',
        'id_user',
        'id_batch',
        'amount',
        'description',
    ];
}
