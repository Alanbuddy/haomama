<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

trait CourseTitleTrait
{
    //
    /**
     * 关联课程标题列表和课时
     * @param $titles
     * @param $lessons
     * @return array
     */
    public function processTitles($titles, $lessons)
    {
        if ($titles) {
            foreach ($titles as $k => $v) {
                if ($lessons->has($k)) {
                    $lessons[$k]->name = $titles[$k];
                } else {
                    $lesson = new Lesson();
                    $lesson->name = $titles[$k];
                    $lessons[] = $lesson;
                }
            }
        }
        return $lessons;
    }
}
