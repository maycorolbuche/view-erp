<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = 'routes';
    protected $primaryKey = 'id_route';

    protected $fillable = [
        'id_route_group',
        'label',
        'name',
        'uri',
        'controller',
        'resources',
        'permissions',
        'icon',
        'sequence',
        'root',
    ];

    protected $casts = [
        'resources' => 'array',
        'permissions' => 'array',
    ];

    public function route_group()
    {
        return $this->hasOne(RouteGroup::class, 'id_route_group', 'id_route_group');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'id_route', 'id_route');
    }
}
