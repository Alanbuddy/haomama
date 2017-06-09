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
                'content' => str_random(30 * $i),
            ]);
        }
    }
}
