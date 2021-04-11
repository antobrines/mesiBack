<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Address;

use Illuminate\Database\Seeder;

class AdressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::where('email', 'admin@dev.fr')->first();
        $user2 = User::where('email', 'user@dev.fr')->first();
        $user3 = User::where('email', 'mod@dev.fr')->first();

        $address = new Address();
        $address->country = "France";
        $address->city = "Lyon";
        $address->postal_code = 69003;
        $address->street = "3 Rue de la liberté";
        $address->type = "Domicile";
        $address->user_id = $user1->id;
        $address->save();

        $address = new Address();
        $address->country = "Belgique";
        $address->city = "Bruxelles";
        $address->postal_code = 1150;
        $address->street = "78 Grand place";
        $address->type = "Domicile";
        $address->user_id = $user2->id;
        $address->save();

        $address = new Address();
        $address->country = "France";
        $address->city = "Paris";
        $address->postal_code = 75009;
        $address->street = "256 Avenue du général de Gaulle";
        $address->type = "Emploi";
        $address->user_id = $user3->id;
        $address->save();
    }
}
