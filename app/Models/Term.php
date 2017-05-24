<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $guarded = [];


    public function coursesByCategory()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    public function coursesByTag()
    {
        return $this->belongsToMany(Course::class, 'term_object', 'term_id', 'object_id');
//            ->withPivot('type')
//            ->where('term_object.type', 'tag');
    }
}
