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
//        admin
        $this->seedAdmin();

//        teacher
        $this->seedTeacher();

        //user
        $this->seedUser();
    }

    /**
     * @return int
     */
    public function seedTeacher()
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => 'teacher' . str_random(6),
                'email' => str_random(10) . '@163.com',
                'password' => bcrypt('1234'),
                'description' => json_encode([
                    'title' => 'ABC',
                    'major' => 'popular disease',
                    'award' => 'blab blab',
                    'book' => '<<asa>>',
                    'introduction' => str_random(20)
                ]),
                'baby' => json_encode([[
                    'name' => str_random(3),
                    'gender' => '男子汉',
                    'birthday' => date('Y-m-d', strtotime('-1 month'))],
                ])
            ]);
        }
    }

    public function seedUser()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('users')->insert([
                    'name' => 'user' . str_random(4),
                    'email' => str_random(5) . '@163.com',
                    'password' => bcrypt('1234'),
                    'baby' => json_encode([[
                        'name' => str_random(3),
                        'gender' => '男子汉',
                        'birthday' => date('Y-m-d', strtotime('-1 month'))],
                    ])
                ]
            );
        }
    }

    public function seedAdmin()
    {
        DB::table('users')->insert([
            'name' => 'aj',
            'email' => 'fishis@163.com',
            'password' => bcrypt('1234'),
            'baby' => json_encode([[
                'name' => str_random(3),
                'gender' => 'male',
                'birthday' => date('Y-m-d', strtotime('-1 month'))],
                'openid'=>'ouxmWjtwxX9y21AX4y3YEHuZHHFY'
            ])
        ]);
    }
}
