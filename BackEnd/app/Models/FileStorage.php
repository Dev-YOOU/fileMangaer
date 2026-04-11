<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileStorage extends Model
{
    protected $fillable = [
        'path',
        'hash',
        'size',
        'mime_type'
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'storage_id');
    }
}
