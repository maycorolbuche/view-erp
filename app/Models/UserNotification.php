<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
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

    public function notification(): HasOne
    {
        return $this->hasOne(Notification::class, 'id_notification', 'id_notification');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function scopeUser(Builder $query, int|string $id_user): Builder
    {
        return $query->where('id_user', $id_user);
    }
}
