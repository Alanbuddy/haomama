<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UserTableSeeder::class);
//        $this->call(EntrustSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CommentSeeder::class);
    }
}