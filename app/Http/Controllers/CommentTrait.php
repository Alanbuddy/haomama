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

    public function latestComments($course, $pageSize = 10)
    {
        return $course->comments()
            ->whereNull('star')
            ->with('user')
            ->with('lesson')
            ->orderBy('id', 'desc')
            ->paginate($pageSize);

    }

    public function hottestComments($course, $pageSize = 10)
    {
        return $course->comments()
            ->whereNull('star')
            ->with('user')
            ->with('votes')
            ->where('course_id', $course->id)
            ->orderBy('vote', 'desc')
            ->paginate($pageSize);
    }
}