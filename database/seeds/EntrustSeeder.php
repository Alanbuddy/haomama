<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = '管理员'; // optional
        $admin->description = '下架课程，人员管理'; // optional
        $admin->save();

        $operator = new Role();
        $operator->name = 'operator';
        $operator->display_name = '运营操作员'; // optional
        $operator->description = '除了下架课程，人员管理所有权限'; // optional
        $operator->save();

        $teacher = new Role();
        $teacher->name = 'teacher';
        $teacher->display_name = '老师'; // optional
        $teacher->description = ''; // optional
        $teacher->save();

        $user = User::find(1);
        $user->attachRole($admin);

        $user = User::find(2);
        $user->attachRole($operator);

        $user = User::where('name', 'like', 'teacher%')->first();
        $user->attachRole(Role::find(3));
    }
}
