<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteGroup extends Model
{
    use HasFactory;

    protected $table = 'routes_groups';
    protected $primaryKey = 'id_route_group';

    protected $fillable = [
        'id_route_group',
        'label',
        'icon',
        'sequence',
        'note',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class, 'id_route_group', 'id_route_group');
    }
}
