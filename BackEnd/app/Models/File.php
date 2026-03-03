<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'original_name',
        'path',
        'size',
        'mime_type',
        'folder_id',
        'user_id'
    ];

    public function folder(){
        return $this->belongsTo(Folder::class);
    }
}
