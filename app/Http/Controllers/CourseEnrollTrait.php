<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-10
 * Time: 上午10:50
 */

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\User;

trait CourseEnrollTrait
{
    //学生加入课程
    public function enroll(Course $course, $user_id = 0)
    {
        $user = auth()->user() ?: User::find($user_id);
        if(empty($user))
            throw new \Exception("User doesn't exist");
//        $user_type = $user->hasRole('teacher') ? 'teacher' : 'student';
//        $course->users()->attach(auth()->user(), ['type' => $type]);
        $count = $course->users()
            ->withPivot('type')
            ->where('type', 'enroll')
            ->where('user_type', 'student')
            ->where('user_id', $user->id)
            ->count();
        if ($count == 0) {
            $changed = $course->users()->attach($user, ['user_type' => 'student']);
        }
        $changed = $course->users()->syncWithoutDetaching($user, ['user_type' => 'student']);
        return ['success' => 'true', 'changed' => $changed];
    }
}