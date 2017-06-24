<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedCourse();

        $this->selectLessons();

        $course = \App\Models\Course::first();
        $teachers = \App\Models\User::where('name', 'like', 'teacher%')->get();
        foreach ($teachers as $user) {
            $course->users()->syncWithoutDetaching([$user->id => ['user_type' => 'teacher']]);
        }

        $users = \App\Models\User::where('name', 'like', 'user%')->get();
        foreach ($users as $user) {
            $course->users()->syncWithoutDetaching([$user->id => ['user_type' => 'student','type'=>'enroll']]);
            $course->users()->syncWithoutDetaching([$user->id => ['user_type' => 'student','type'=>'favorite']]);
        }
        $admin=\App\Models\User::first();
        $courses=\App\Models\Course::get();
        foreach ($courses as $course){
            $course->users()->syncWithoutDetaching([$admin->id => ['user_type' => 'student','type'=>'favorite']]);
            $course->users()->syncWithoutDetaching([$admin->id => ['user_type' => 'student','type'=>'enroll']]);
        }
    }

    /**
     * @return int
     */
    public function seedCourse()
    {
        for ($i = 0; $i < 22; $i++) {
            DB::table('courses')->insert([
                'name' => str_random('7'),
                'teacher_id' => 1,
                'category_id' => 12,
                'price' => rand(10, 100),
                'type' => $i % 2 == 0 ? 'online' : 'offline',
                'status' => 'publish',
                'description' => 'some description',
                'cover' => '/storage/a.png',
                'begin' => date('Y-m-d H:i:s', time()),
                'end' => date('Y-m-d H:i:s', strtotime("+1 week")),
                'created_at' => date('Y-m-d H:i:s', strtotime("+" . $i . " week")),
            ]);
        }
        return $i;
    }

    public function selectLessons()
    {
        for ($i = 0; $i < 20; $i++) {
            $lessons = \App\Models\Lesson::get();
            DB::table('course_lesson')->insert([
                'course_id' => 1,
                'lesson_id' => $lessons[$i]->id,
            ]);
            DB::table('course_lesson')->insert([
                'course_id' => 2,
                'lesson_id' => $lessons[$i]->id,
            ]);
        }
    }
}
