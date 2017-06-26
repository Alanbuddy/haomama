<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsToMany(Course::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    //TODO comments($course_id)
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->whereNull('star');
    }

    public function attendances($course_id)
    {
        return $this->hasMany('App\Models\Attendance')->where('course_id',$course_id);
    }
}
