<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Authorization extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'authorizations';
    protected $primaryKey = 'id_authorization';

    protected $fillable = [
        'id_authorization_parent',
        'id_user',
        'id_authorization_type',
        'description',
        'start_datetime',
        'end_datetime',
        'amount',
        'self',
        'active',
        'approved',
        'agreement_terms',
    ];

    protected $appends = ['description_details'];


    public function getStartDateAttribute()
    {
        return Carbon::parse($this->start_datetime)->format('Y-m-d');
    }

    public function getEndDateAttribute()
    {
        return Carbon::parse($this->end_datetime)->format('Y-m-d');
    }

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

    public function authorization_parent()
    {
        return $this->hasOne(Authorization::class, 'id_authorization', 'id_authorization_parent');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function scopeMe($query)
    {
        return $query->where('id_user', Auth::id());
    }
    public function scopeWithMe($query)
    {

        return $query->where(function ($q) {
            $q->whereHas('statuses', function ($subQuery) {
                $subQuery->where((new AuthorizationStatus)->getTable() . '.id_user', Auth::id());
            })->orWhere((new Authorization)->getTable() . '.id_user', Auth::id());
        });
    }
    public function scopeType($query, $type)
    {
        return $query->whereHas('authorization_type', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }
}
