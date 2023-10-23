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
        'id_route_parent',
        'label',
        'name',
        'uri',
        'controller',
        'resources',
        'permissions',
        'icon',
        'sequence',
    ];

    protected $casts = [
        'resources' => 'array',
        'permissions' => 'array',
    ];
}
