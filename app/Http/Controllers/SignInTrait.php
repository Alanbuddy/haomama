<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-6-30
 * Time: 上午10:02
 */

namespace App\Http\Controllers;


use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lesson;

trait SignInTrait
{
    //记录线上课程到访情况，用来统计课程的学习次数
    public function recordAttendance(Course $course, Lesson $lesson)
    {
        $hasAttended = (bool)Attendance::where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->where('user_id', auth()->user()->id)
            ->count();
        if (!$hasAttended) {
            $attendance = new Attendance();
            $attendance->fill([
                'course_id' => $course->id,
                'lesson_id' => $lesson->id,
                'user_id' => auth()->user()->id,
            ]);
            $attendance->save();
        }
    }

}