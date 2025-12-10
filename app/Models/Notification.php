<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Notification extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'notifications';
    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'slug',
        'name',
        'id_route',
    ];

    public function users_notifications()
    {
        return $this->hasMany(UserNotification::class, 'id_notification', 'id_notification');
    }
}
