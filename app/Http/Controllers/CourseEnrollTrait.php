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
use Carbon\Carbon;

trait CourseEnrollTrait
{
    //学生加入课程
    public function enroll(Course $course, $user_id = 0)
    {
        $user = auth()->user() ?: User::find($user_id);
        $success = true;
        if ($course->type == 'offline' && $course->quota)
            if($course->students()->count() == $course->quota)
        if (empty($user))
            throw new \Exception("User doesn't exist");
//        $user_type = $user->hasRole('teacher') ? 'teacher' : 'student';
//        $course->users()->attach(auth()->user(), ['type' => $type]);
        $count = $this->hasEnrolled($course, $user->id);
        if ($count == 0) {
            $changed = $course->users()->attach($user, [
                'user_type' => 'student',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $changed = $course->users()->syncWithoutDetaching($user, ['user_type' => 'student']);
        return ['success' => $success, 'changed' => $changed];
    }

    public function hasEnrolled($course, $userId)
    {
        return $course->users()
            ->withPivot('type')
            ->where('type', 'enroll')
            ->where('user_type', 'student')
            ->where('user_id', $userId)
            ->count();
    }
}