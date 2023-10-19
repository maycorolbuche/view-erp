<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $primaryKey = 'id_profile';

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'id_profile', 'id_profile');
    }
}
