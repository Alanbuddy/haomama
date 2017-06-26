<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {

            DB::table('comments')->insert([
                'user_id' => 1,
                'star' => rand(1, 5),
                'course_id' => 1
            ]);
        }
        for ($i = 0; $i < 20; $i++) {

            $comment = new \App\Models\Comment();
            $comment->fill([
                'user_id' => 1,
                'content' => str_random(3 * $i),
                'course_id' => 1,
                'lesson_id' => 1
            ]);
            $comment->save();
        }
    }
}
