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
        $admin->name         = 'admin';
        $admin->display_name = '管理员'; // optional
        $admin->description  = 'User is allowed to manage and edit other users'; // optional
        $admin->save();

        $teacher = new Role();
        $teacher->name         = 'teacher';
        $teacher->display_name = '老师'; // optional
        $teacher->description  = ''; // optional
        $teacher->save();

        $user=User::find(1);
        $user->attachRole($admin);

        $user=User::where('name','like','teacher%')->first();
        $user->attachRole(Role::find(2));
    }
}
