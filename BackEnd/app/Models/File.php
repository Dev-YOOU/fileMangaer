<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'folder_id',
        'storage_id',
        'user_id'
    ];

    public function folder(){
        return $this->belongsTo(Folder::class);
    }

    public function storage()
    {
        return $this->belongsTo(FileStorage::class, 'storage_id');
    }
}
