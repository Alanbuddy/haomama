<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait; // add this trait to your user model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function behaviors()
    {
        return $this->hasMany('App\Models\Behavior');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany('App\Models\Course')
            ->wherePivot('type', 'enroll');
    }

    public function coachingCourse()
    {
        return $this->belongsToMany('App\Models\Course')
            ->wherePivot('user_type', 'teacher');
    }

    public function favoritedCourses()
    {
        return $this->belongsToMany('App\Models\Course')
            ->wherePivot('type', 'favorite');
    }

    public function onGoingCourses()
    {
        return $this->enrolledCourses('App\Models\Course')
            ->where('begin','<',date('Y-m-d H:i:s',time()))
            ->where('end','>',date('Y-m-d H:i:s',time()));
    }
    //教师获得的赞
    public function votes()
    {
        return $this->hasMany('App\Models\Vote','teacher_id');
    }

    //发给我的消息
    public function messages()
    {
        return $this->hasMany('App\Models\Message','to');
    }
}
