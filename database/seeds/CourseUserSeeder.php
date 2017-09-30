<?php

use Illuminate\Database\Seeder;

class CourseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = \App\Models\Course::first();
        $teachers = \App\Models\User::where('name', 'like', 'teacher%')->get();
        foreach ($teachers as $user) {
            $course->users()->syncWithoutDetaching([$user->id => ['user_type' => 'teacher']]);
        }

        $users = \App\Models\User::where('name', 'like', 'user%')->get();
        foreach ($users as $user) {
//            $course->users()->syncWithoutDetaching([$user->id => ['user_type' => 'student','type'=>'enroll']]);
            $course->users()->attach([$user->id => ['user_type' => 'student','type'=>'enroll']]);
            $course->users()->attach([$user->id => ['user_type' => 'student','type'=>'favorite']]);
        }
        $admin = \App\Models\User::first();
        $courses = \App\Models\Course::get();
        foreach ($courses as $course) {
//            $course->users()->syncWithoutDetaching([$admin->id => ['user_type' => 'student', 'type' => 'favorite']]);
            $course->users()->attach([$admin->id => ['user_type' => 'student', 'type' => 'favorite']]);
            $course->users()->attach([$admin->id => ['user_type' => 'student', 'type' => 'enroll']]);
        }
    }
}
