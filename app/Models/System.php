<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $table = 'systems';
    protected $primaryKey = 'id_system';

    protected $fillable = [
        'slug',
        'name',
        'icon',
        'root'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, UserSystem::class, 'id_system', 'id_user');
    }
}
