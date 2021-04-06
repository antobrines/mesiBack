<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->name = "user";
        $role_user->description = "This is a basic user without any permissions in the app";
        $role_user->save();

        $role_user = new Role();
        $role_user->name = "moderator";
        $role_user->description = "This is an moderator his got some permissions";
        $role_user->save();

        $role_user = new Role();
        $role_user->name = "admin";
        $role_user->description = "This is an admin of the application, his got all the permissions";
        $role_user->save();
    }
}
