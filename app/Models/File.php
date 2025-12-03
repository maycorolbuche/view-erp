<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id_file';

    protected $fillable = [
        'original_name',
        'stored_name',
        'extension',
        'mime_type',
        'size',
        'path',
        'type',
        'disk',
        'hash',
    ];


    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
