<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        for ($i = 0; $i < 10; $i++) {
//            DB::table('terms')->insert([
//                'name' => '标签' . str_random('2'),
//                'type' => 'tag'
//            ]);
//        }

        $arr = ['健康养育', '心理教育', '自我成长'];
        for ($i = 0; $i < 3; $i++) {
            DB::table('terms')->insert([
                'name' => $arr[$i],
                'type' => 'category'
            ]);
        }
    }
}
