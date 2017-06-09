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
        for ($i = 0; $i < 7; $i++) {
            DB::table('courses')->insert([
                'name' => str_random('7'),
                'teacher_id' => 1,
                'category_id' => 12,
                'price' => rand(10, 100),
                'type' => 'online',
                'status' => 'publish',
                'description' => 'some description',
                'cover' => '/storage/a.png',
                'begin' => date('Y-m-d H:i:s', time()),
                'end' => date('Y-m-d H:i:s', strtotime("+1 week")),
                'created_at' => date('Y-m-d H:i:s', strtotime("+" . $i . " week")),
            ]);
        }

        DB::table('course_lesson')->insert([
            'course_id' => 1,
            'lesson_id' => 1,
        ]);
    }
}
