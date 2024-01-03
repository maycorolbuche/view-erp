<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class BatchCategory extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'batches_categories';
    protected $primaryKey = 'id_batch_category';

    protected $fillable = [
        'id_batch',
        'id_category',
        'amount',
        'expenses_count',
    ];
}
