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

//        operator
        $this->seedOperator();

//        teacher
        $this->seedTeacher();

        //user
//        $this->seedUser();
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
                    'basicIntroduction' => str_random(20),
                    'introduction' => str_random(20),
                    'remark' => str_random(10),
                    'telephone' => rand(100000,999999),
                    'qq' => rand(10000000,99999999),
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
        for ($i = 0; $i < 20; $i++) {
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
            'name' => 'adminDemo',
            'email' => 'admin@163.com',
            'phone' => '18912341234',
            'password' => bcrypt('123'),
            'baby' => json_encode([[
                'name' => str_random(3),
                'gender' => 'male',
                'birthday' => date('Y-m-d', strtotime('-1 month'))],
            ]),
            'openid' => 'ouxmWjtwxX9y21AX4y3YEHuZHHFY',
            'wx' => ' {"sex": 1, "city": "Luliang", "openid": "ouxmWjtwxX9y21AX4y3YEHuZHHFY", "country": "CN", "language": "zh_CN", "nickname": "高尚衡", "province": "Shanxi", "privilege": [], "headimgurl": "http://wx.qlogo.cn/mmopen/oy6t7Y5iag6Qf6iaUh3EGArfnVdgDEyo0tRia3dGfoq0MmRykBySPbibYS79VsRFjIm8IX7a9ticnITN97NF7GhJBC2iaYJJQxSsq5/0"}'
        ]);
    }

    public function seedOperator()
    {
        DB::table('users')->insert([
            'name' => 'operatorDemo',
            'email' => 'operatorDemo@163.com',
            'phone' => '18812341234',
            'password' => bcrypt('123'),
        ]);
    }
}
