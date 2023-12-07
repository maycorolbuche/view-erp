<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Batch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'batches';
    protected $primaryKey = 'id_batch';

    protected $fillable = [
        'id_user',
        'active',
        'automatic_batch',
        'expenses_count',
        'amount',
        'refundable_amount',
        'non_refundable_amount',
        'discount',
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
}
