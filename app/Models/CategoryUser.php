<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CategoryUser extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'categories_users';
    protected $primaryKey = 'id_category_user';

    protected $fillable = [
        'id_category',
        'id_user',
    ];
}
