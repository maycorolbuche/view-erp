<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class BatchClient extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'batches_clients';
    protected $primaryKey = 'id_batch_client';

    protected $fillable = [
        'id_batch',
        'id_client',
        'amount',
        'expenses_count',
    ];
}
