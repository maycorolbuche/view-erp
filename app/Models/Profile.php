<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Profile extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'profiles';
    protected $primaryKey = 'id_profile';

    protected $fillable = [
        'name',
        'root',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'id_profile', 'id_profile');
    }

}
