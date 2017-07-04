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
        $this->call(UserTableSeeder::class);
        $this->call(EntrustSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseUserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CommentSeeder::class);
        DB::table('term_object')->insert(['term_id' => 1, 'object_id' => 1, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 2, 'object_id' => 1, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 3, 'object_id' => 1, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 3, 'object_id' => 2, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 1, 'object_id' => 2, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 2, 'object_id' => 3, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 1, 'object_id' => 4, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 1, 'object_id' => 5, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 2, 'object_id' => 5, 'type' => 'tag',]);
        DB::table('term_object')->insert(['term_id' => 3, 'object_id' => 5, 'type' => 'tag',]);
        $this->call(VoteSeeder::class);

    }
}