<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin
//        DB::table('users')->insert([
//            'name' => 'aj',
//            'email' => 'fishis@163.com',
//            'password' => bcrypt('1234'),
//            'baby' => json_encode([[
//                'name' => str_random(3),
//                'gender' => 'male',
//                'birthday' => date('Y-m-d', strtotime('-1 month'))],
//            ])
//        ]);

       //teacher
        DB::table('users')->insert([
            'name' => 'teacher0',
            'email' => 'fis@163.com',
            'password' => bcrypt('1234'),
            'baby' => json_encode([[
                'name' => str_random(3),
                'gender' => '男子汉',
                'birthday' => date('Y-m-d', strtotime('-1 month'))],
            ])
        ]);
        DB::table('users')->insert([
                'name' => str_random(4),
                'email' => str_random(5) . '@163.com',
                'password' => bcrypt('1234'),
                'baby' => json_encode([[
                    'name' => str_random(3),
                    'gender' => 'male',
                    'birthday' => date('Y-m-d', strtotime('-1 month'))],
                ])
            ]
        );
    }
}
