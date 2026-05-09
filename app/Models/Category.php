<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function users()
    {
        return $this->hasMany(CategoryUser::class, 'id_category', 'id_category');
    }

    public function scopeVisible(Builder $query, ?int $idUser = null): Builder
    {
        $idUser = $idUser ?? auth()->user()->id_user;

        return $query->where(function ($q) use ($idUser) {
            // sem vínculos
            $q->whereDoesntHave('users')

                // OU vinculado ao usuário
                ->orWhereHas('users', function ($sub) use ($idUser) {
                    $sub->where('id_user', $idUser);
                });
        });
    }
}
