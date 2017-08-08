<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded=[];

    public function course()
    {
        return $this->belongsTo(Course::class,'id','product_id');
    }
}
