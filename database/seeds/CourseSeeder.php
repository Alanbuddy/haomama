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


    }

    /**
     * @return int
     */
    public function seedCourse()
    {
        $category = \App\Models\Term::where('type', 'category')->first();
        for ($i = 0; $i < 22; $i++) {
            DB::table('courses')->insert([
                'name' => str_random('7'),
                'teacher_id' => 1,
                'category_id' => $category->id,
                'price' => rand(10, 100),
                'original_price' => 100,
                'hot' => $i == 11 ? 1 : 0,
                'type' => $i % 2 == 0 ? 'online' : 'offline',
                'status' => 'publish',
                'description' => 'some description',
                'cover' => '/icon/course.png',
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
                'no' => 20 - $i,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . $i . ' hours')),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('course_lesson')->insert([
                'course_id' => 2,
                'lesson_id' => $lessons[$i]->id,
                'no' => 40 - $i,
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . $i . ' days')),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

}
