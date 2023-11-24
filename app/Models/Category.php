<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Category extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'categories';
    protected $primaryKey = 'id_category';

    protected $fillable = [
        'name',
        'short_name',
        'id_category_type',
    ];


    public function category_type()
    {
        return $this->hasOne(CategoryType::class, 'id_category_type', 'id_category_type');
    }
}
