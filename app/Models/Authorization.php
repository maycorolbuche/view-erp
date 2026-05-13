<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\CreatedUpdatedBy;
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

    public function scopeMe(Builder $query)
    {
        return $query->where('id_user', auth()->id());
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    public function scopePending(Builder $query)
    {
        return $query->where('approved', null);
    }

    public function scopeApproved(Builder $query)
    {
        return $query->where('approved', true);
    }

    public function scopeWithMe(Builder $query)
    {
        return $query->where(function ($q) {
            $q->whereHas('statuses', function ($subQuery) {
                $subQuery->where((new AuthorizationStatus)->getTable() . '.id_user', auth()->id());
            })->orWhere((new Authorization)->getTable() . '.id_user', auth()->id());
        });
    }

    public function scopeType(Builder $query, string $type)
    {
        return $query->whereHas('authorization_type', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }

    public static function getActiveExpenses()
    {
        return self::with(['clients', 'statuses', 'user', 'authorization_type'])
            ->me()
            ->type('expense')
            ->active()
            ->approved()
            ->latest()
            ->get();
    }

    public function scopePendingResponse(Builder $query, ?int $id_user = null)
    {
        $id_user ??= auth()->id();

        return $query->with([
            'clients',
            'statuses',
            'user',
            'authorization_type'
        ])
            ->whereHas('statuses', function ($query) use ($id_user) {
                $query->where('authorizations_statuses.id_user', $id_user)
                    ->whereNull('approved');
            })
            ->type('expense')
            ->active()
            ->pending();
    }

    public static function getPendingResponse(?int $id_user = null)
    {
        return self::pendingResponse($id_user)
            ->latest()
            ->get();
    }

    public static function getPendingResponseCount(?int $id_user = null)
    {
        return self::pendingResponse($id_user)
            ->count();
    }
}
