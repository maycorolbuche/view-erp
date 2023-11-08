<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class UserDependent extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'users_dependents';
    protected $primaryKey = 'id_user_dependent';

    protected $fillable = [
        'id_user',
        'id_relationship_degree',
        'name',
        'birth_date',
    ];

    public function relationship_degree()
    {
        return $this->hasOne(RelationshipDegree::class, 'id_relationship_degree', 'id_relationship_degree');
    }
}
