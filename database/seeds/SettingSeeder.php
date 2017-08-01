<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([ 'key' => 'access_token',
            'value' => '{"access_token":"example","expire_time":1497937039}' ]);
        DB::table('settings')->insert([ 'key' => 'carousel',
            'value' => '[]' ]);
        $this->setRecommendedCourse();
    }
    public function setRecommendedCourse()
    {
        DB::table('settings')->insert(['key' => 'recommendedCourse',
            'value' => '',
        ]);
    }
}
