<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    use HasFactory;

    protected $table = 'task_logs';
    protected $primaryKey = 'id_task_log';

    protected $fillable = [
        'signature',
        'description',
        'details',
        'start_time',
        'end_time',
    ];
}
