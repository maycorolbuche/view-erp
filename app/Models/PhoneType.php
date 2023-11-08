<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class PhoneType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'phones_types';
    protected $primaryKey = 'id_phone_type';

    protected $fillable = [
        'description',
    ];
}
