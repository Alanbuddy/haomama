<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-5
 * Time: 上午10:29
 */

namespace App\Http\Controllers;


trait CommentTrait
{

    public function latestComments($course, $lesson, $pageSize = 10)
    {
        return $course->comments()
            ->whereNull('star')
            ->where('validity', true)
            ->orWhere(function ($query) {
                if (auth()->check())
                    $query->where('validity', false)
                        ->where('user_id', auth()->user()->id);
            })
            ->whereNull('star')
            ->where('lesson_id', $lesson->id)
            ->with('user')
            ->with('lesson')
            ->orderBy('id', 'desc')
            ->paginate($pageSize);
    }

    public function hottestComments($course, $lesson, $pageSize = 10)
    {
        return $course->comments()
            ->whereNull('star')
            ->where('validity', true)
            ->orWhere(function ($query) {
                if (auth()->check())
                    $query->where('validity', false)
                        ->where('user_id', auth()->user()->id);
            })
            ->whereNull('star')
            ->where('lesson_id', $lesson->id)
            ->with('user')
            ->with('votes')
            ->where('course_id', $course->id)
            ->orderBy('vote', 'desc')
            ->paginate($pageSize);
    }

}