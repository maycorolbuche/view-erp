<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserTeam extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_teams';
    protected $primaryKey = 'id_user_team';

    protected $fillable = [
        'id_user_parent',
        'id_user_child',
    ];


    public function parent(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_parent');
    }

    public function child(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_child');
    }

    public function users_authorizations_types(): HasMany
    {
        return $this->hasMany(UserAuthorizationType::class, 'id_user_parent', 'id_user_parent')
            ->where('id_user_child', $this->id_user_child);
    }

    public function scopeUser(Builder $query, int|string $id_user): Builder
    {
        return $query->where('id_user_parent', $id_user)->orWhere('id_user_child', $id_user);
    }
}
