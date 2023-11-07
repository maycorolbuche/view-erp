<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class RelationshipDegree extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'relationships_degrees';
    protected $primaryKey = 'id_relationship_degree';

    protected $fillable = [
        'name',
    ];
}
