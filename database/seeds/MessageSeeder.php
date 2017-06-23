<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
//            DB::table('messages')->insert([ ]);

            $message=new \App\Models\Message();

            $message->fill([
                'to' => '1',
                'content' => str_random(20),
            ]);

            $message->save();
        }
    }
}
