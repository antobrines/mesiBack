<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
        $role_user = Role::where('name', 'user')->first();
        $role_moderator = Role::where('name', 'moderator')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $user = new User();
        $user->first_name = 'Henry';
        $user->last_name = 'Strong';
        $user->created_at = now();
        $user->email = 'user@dev.fr';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->first_name = 'Randy';
        $user->last_name = 'Orton';
        $user->created_at = now();
        $user->email = 'mod@dev.fr';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user->save();
        $user->roles()->attach($role_moderator);

        $user = new User();
        $user->first_name = 'Jhon';
        $user->last_name = 'Cena';
        $user->created_at = now();
        $user->email = 'admin@dev.fr';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
