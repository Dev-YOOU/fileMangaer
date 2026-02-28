<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class folder extends Model
{
    protected $fillable = [];
    public function files()
    {
        return $this->hasMany(file::class);
    }
    public function folders()
    {
        return $this->hasMany(folder::class, 'parent_id')->with('folders');
    }
}
