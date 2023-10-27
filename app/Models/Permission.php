<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Permission extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'permissions';
    protected $primaryKey = 'id_permission';

    protected $fillable = [
        'id_route',
        'id_system',
        'id_user',
        'id_profile',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function route()
    {
        return $this->hasOne(Route::class, 'id_route', 'id_route');
    }
}
