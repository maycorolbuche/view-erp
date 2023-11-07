<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getShortNameAttribute()
    {
        $names = explode(' ', trim($this->name));
        $firstName = $names[0];
        $lastName = (count($names) > 1 ? ' ' . end($names) : '');

        return $firstName . $lastName;
    }

    public function getInitialsAttribute()
    {
        $names = explode(' ', mb_strtoupper(trim($this->name)));
        $firstName = mb_substr($names[0], 0, 1, 'UTF-8');
        $lastName = (count($names) > 1 ? mb_substr(end($names), 0, 1, 'UTF-8') : '');

        return $firstName . $lastName;
    }


    public function systems()
    {
        return $this->belongsToMany(System::class, UserSystem::class, 'id_user', 'id_system');
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, UserProfile::class, 'id_user', 'id_profile')->withPivot('id_user_profile');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'id_user', 'id_user');
    }

    public function employment_type()
    {
        return $this->hasOne(EmploymentType::class, 'id_employment_type', 'id_employment_type');
    }

    public function users_dependents()
    {
        return $this->hasMany(UserDependent::class, 'id_user', 'id_user');
    }

    public function users_parent()
    {
        return $this->hasOne(UserTeam::class, 'id_user_child', 'id_user');
    }

    public function users_child()
    {
        return $this->hasOne(UserTeam::class, 'id_user_parent', 'id_user');
    }

    public function getDependentsCountAttribute()
    {
        if ($this->relationLoaded('users_dependents')) {
            return $this->users_dependents->count();
        }

        return $this->users_dependents()->count();
    }

    public function getParentsCountAttribute()
    {
        if ($this->relationLoaded('users_parent')) {
            return $this->users_parent->count();
        }

        return $this->users_parent()->count();
    }

    public function getChildsCountAttribute()
    {
        if ($this->relationLoaded('users_child')) {
            return $this->users_child->count();
        }

        return $this->users_child()->count();
    }
}
