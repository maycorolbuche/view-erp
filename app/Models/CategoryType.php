<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CategoryType extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'categories_types';
    protected $primaryKey = 'id_category_type';

    protected $fillable = [
        'name',
        'slug',
    ];
}
