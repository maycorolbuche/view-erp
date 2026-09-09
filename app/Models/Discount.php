<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Discount extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'discounts';
    protected $primaryKey = 'id_discount';

    protected $fillable = [
        'name',
    ];

    public function discounts_categories(): HasMany
    {
        return $this->hasMany(DiscountCategory::class, 'id_discount', 'id_discount');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, DiscountCategory::class, 'id_discount', 'id_category');
    }

    public function discounts_amounts(): HasMany
    {
        return $this->hasMany(DiscountAmount::class, 'id_discount', 'id_discount');
    }
}
