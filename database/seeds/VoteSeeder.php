<?php

use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            $vote=new \App\Models\Vote();
            $vote->fill([
                'user_id' => 1,
                'comment_id'=>1
            ]);
            $vote->save();
        }

    }
}
