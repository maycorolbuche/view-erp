<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_logs';
    protected $primaryKey = 'id_notification_log';

    protected $fillable = [
        'notification_type',
        'notifiable_type',
        'id_user',
        'channel',
        'recipient',
        'subject',
        'message',
        'data',
        'type',
        'response',
        'status',
        'error_message',
        'sent_at',
    ];


    protected $casts = [
        'data' => 'array',
        'response' => 'array',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = [
        'sent_at',
        'created_at',
        'updated_at',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
