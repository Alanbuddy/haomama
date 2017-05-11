<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video');
    }
}
