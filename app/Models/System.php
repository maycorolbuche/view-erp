<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $table = 'systems';
    protected $primaryKey = 'id_system';

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_systems', 'id_system', 'id_user');
    }
}
