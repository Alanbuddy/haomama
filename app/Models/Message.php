<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $guarded=[];

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment','object_id')
            ->orderBy('comments.id','desc');
    }
}
