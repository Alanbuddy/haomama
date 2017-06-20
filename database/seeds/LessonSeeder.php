<?php

use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('lessons')->insert([
                'name' => str_random('7'),
                'video_id' => '3'
            ]);
        }
    }
}
