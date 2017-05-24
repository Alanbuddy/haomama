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
        for ($i = 0; $i < 10; $i++) {
            DB::table('terms')->insert([
                'name' => '标签' . str_random('2'),
                'type' => 'tag'
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            DB::table('terms')->insert([
                'name' => '分类' . str_random('1'),
                'type' => 'category'
            ]);
        }
    }
}
