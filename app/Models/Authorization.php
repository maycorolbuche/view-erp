<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
use Carbon\Carbon;

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

    protected $appends = ['description_details'];

    public function getStartDatetimeBrAttribute()
    {
        return Carbon::parse($this->start_datetime)->format('d/m/Y H:i:s');
    }

    public function getEndDatetimeBrAttribute()
    {
        return Carbon::parse($this->end_datetime)->format('d/m/Y H:i:s');
    }

    public function getStartDateBrAttribute()
    {
        return Carbon::parse($this->start_datetime)->format('d/m/Y');
    }

    public function getEndDateBrAttribute()
    {
        return Carbon::parse($this->end_datetime)->format('d/m/Y');
    }

    public function getDescriptionDetailsAttribute()
    {
        $description = "";
        if ($this->authorization_type->type == "expense") {
            $description .= $this->start_date_br . " - " . $this->end_date_br;
        } else {
            $description .= $this->start_datetime_br . " - " . $this->end_datetime_br;
        }

        foreach ($this->clients as $key => $client) {
            $description .= ($key <= 0 ? ' | ' : ', ') . $client->name;
        }

        return $description;
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, AuthorizationClient::class, 'id_authorization', 'id_client');
    }

    public function statuses()
    {
        return $this->belongsToMany(User::class, AuthorizationStatus::class, 'id_authorization', 'id_user')->withPivot(['approved', 'description']);
    }

    public function authorization_statuses()
    {
        return $this->hasMany(AuthorizationStatus::class, 'id_authorization', 'id_authorization');
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
