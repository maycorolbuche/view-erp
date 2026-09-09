<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
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


    public function getStartDateAttribute(): string
    {
        return Carbon::parse($this->start_datetime)->format('Y-m-d');
    }

    public function getEndDateAttribute(): string
    {
        return Carbon::parse($this->end_datetime)->format('Y-m-d');
    }

    public function getStartDatetimeBrAttribute(): string
    {
        return Carbon::parse($this->start_datetime)->format('d/m/Y H:i:s');
    }

    public function getEndDatetimeBrAttribute(): string
    {
        return Carbon::parse($this->end_datetime)->format('d/m/Y H:i:s');
    }

    public function getStartDateBrAttribute(): string
    {
        return Carbon::parse($this->start_datetime)->format('d/m/Y');
    }

    public function getEndDateBrAttribute(): string
    {
        return Carbon::parse($this->end_datetime)->format('d/m/Y');
    }

    public function getDescriptionDetailsAttribute(): string
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

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, AuthorizationClient::class, 'id_authorization', 'id_client');
    }

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(User::class, AuthorizationStatus::class, 'id_authorization', 'id_user')->withPivot(['approved', 'description']);
    }

    public function authorization_statuses(): HasMany
    {
        return $this->hasMany(AuthorizationStatus::class, 'id_authorization', 'id_authorization');
    }

    public function authorization_type(): HasOne
    {
        return $this->hasOne(AuthorizationType::class, 'id_authorization_type', 'id_authorization_type');
    }

    public function authorization_parent(): HasOne
    {
        return $this->hasOne(Authorization::class, 'id_authorization', 'id_authorization_parent');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function scopeMe(Builder $query): Builder
    {
        return $query->where('id_user', Auth::id());
    }
    public function scopeWithMe(Builder $query): Builder
    {

        return $query->where(function (Builder $q) {
            $q->whereHas('statuses', function (Builder $subQuery) {
                $subQuery->where((new AuthorizationStatus)->getTable() . '.id_user', Auth::id());
            })->orWhere((new Authorization)->getTable() . '.id_user', Auth::id());
        });
    }
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->whereHas('authorization_type', function (Builder $q) use ($type) {
            $q->where('type', $type);
        });
    }
}
