<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Models\Lesson');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }
}
