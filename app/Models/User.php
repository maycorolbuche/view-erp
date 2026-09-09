<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword;
use App\Traits\CreatedUpdatedBy;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, CreatedUpdatedBy;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'active',
        'last_access',
        'count_access',
        'root',
        'id_employment_type',
        'cpf_or_cnpj',
        'id_card',
        'pis',
        'birth_date',
        'id_civil_status',
        'zip_code',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'id_branch',
        'hire_date',
        'termination_date',
        'admission_notes'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function updateLastAccess(): void
    {
        $this->update([
            'last_access' => now(),
            'count_access' => ($this->count_access ?? 0) + 1,
        ]);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Always encrypt password when it is updated.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function sendPasswordResetNotification(mixed $token): void
    {
        $this->notify(new ResetPassword($token));
    }

    public function getShortNameAttribute(): string
    {
        $names = explode(' ', trim($this->name));
        $firstName = $names[0];
        $lastName = (count($names) > 1 ? ' ' . end($names) : '');

        return $firstName . $lastName;
    }

    public function getInitialsAttribute(): string
    {
        $names = explode(' ', mb_strtoupper(trim($this->name)));
        $firstName = mb_substr($names[0], 0, 1, 'UTF-8');
        $lastName = (count($names) > 1 ? mb_substr(end($names), 0, 1, 'UTF-8') : '');

        return $firstName . $lastName;
    }


    public function getDependentsCountAttribute(): int
    {
        if ($this->relationLoaded('users_dependents')) {
            return $this->users_dependents->count();
        }

        return $this->users_dependents()->count();
    }

    public function getParentsCountAttribute(): int
    {
        if ($this->relationLoaded('users_parent')) {
            return $this->users_parent->count();
        }

        return $this->users_parent()->count();
    }

    public function getChildsCountAttribute(): int
    {
        if ($this->relationLoaded('users_child')) {
            return $this->users_child->count();
        }

        return $this->users_child()->count();
    }

    public function getPhonesCountAttribute(): int
    {
        if ($this->relationLoaded('users_phones')) {
            return $this->users_phones->count();
        }

        return $this->users_phones()->count();
    }

    public function getCertificationsCountAttribute(): int
    {
        if ($this->relationLoaded('users_certifications')) {
            return $this->users_certifications->count();
        }

        return $this->users_certifications()->count();
    }



    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, UserProfile::class, 'id_user', 'id_profile')->withPivot('id_user_profile');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'id_user', 'id_user');
    }

    public function employment_type(): HasOne
    {
        return $this->hasOne(EmploymentType::class, 'id_employment_type', 'id_employment_type');
    }

    public function users_dependents(): HasMany
    {
        return $this->hasMany(UserDependent::class, 'id_user', 'id_user');
    }

    public function users_parent(): HasOne
    {
        return $this->hasOne(UserTeam::class, 'id_user_child', 'id_user');
    }

    public function users_child(): HasOne
    {
        return $this->hasOne(UserTeam::class, 'id_user_parent', 'id_user');
    }

    public function users_phones(): HasMany
    {
        return $this->hasMany(UserPhone::class, 'id_user', 'id_user');
    }

    public function users_certifications(): HasMany
    {
        return $this->hasMany(UserCertification::class, 'id_user', 'id_user');
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id_branch', 'id_branch');
    }

    public function users_discounts(): HasMany
    {
        return $this->hasMany(UserDiscount::class, 'id_user', 'id_user');
    }

    public function users_notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'id_user', 'id_user');
    }

    public function users_cash(): HasOne
    {
        return $this->hasOne(UserCash::class, 'id_user', 'id_user');
    }

    public function user_cash(): HasOne
    {
        return $this->hasOne(UserCash::class, 'id_user', 'id_user');
    }
}
