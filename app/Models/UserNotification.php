<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserNotification extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_notifications';
    protected $primaryKey = 'id_user_notification';

    protected $fillable = [
        'id_user',
        'id_notification',
        'required',
    ];

    public function notification()
    {
        return $this->hasOne(Notification::class, 'id_notification', 'id_notification');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
}
