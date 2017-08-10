<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class)
            ->withPivot('no');
    }

    public function onGoingLessons()
    {
        return $this->belongsToMany(Lesson::class)
            ->whereNotNull('lessons.end')
            ->where('lessons.end', '>', date('Y-m-d H:i:s', time()));
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Term', 'term_object', 'object_id', 'term_id')
            ->where('term_object.type', 'tag');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Term', 'category_id');
//        return $this->belongsToMany('App\Models\Term', 'term_object', 'object_id', 'term_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\User')
            ->wherePivot('user_type', 'teacher');
    }

    public function students()
    {
        return $this->belongsToMany('App\Models\User')
            ->wherePivot('user_type', 'student')
            ->wherePivot('type', 'enroll');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'product_id');
    }

}

