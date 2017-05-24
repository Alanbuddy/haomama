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

    public function enrolledCourses()
    {
        return $this->belongsToMany('App\Models\Course')
            ->wherePivot('type', 'enroll');
    }

    public function favoritedCourses()
    {
        return $this->belongsToMany('App\Models\Course')
            ->wherePivot('type', 'favorite');
    }
}
