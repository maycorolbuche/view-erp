<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Authorization extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations';
    protected $primaryKey = 'id_authorization';

    protected $fillable = [
        'id_user',
        'id_authorization_type',
        'description',
        'start_datetime',
        'end_datetime',
        'self',
        'active',
        'approved',
    ];


    public function clients()
    {
        return $this->belongsToMany(Client::class, AuthorizationClient::class, 'id_authorization', 'id_client');
    }

    public function statuses()
    {
        return $this->belongsToMany(User::class, AuthorizationStatus::class, 'id_authorization', 'id_user')->withPivot('approved');
    }

    public function authorization_type()
    {
        return $this->hasOne(AuthorizationType::class, 'id_authorization_type', 'id_authorization_type');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
}
