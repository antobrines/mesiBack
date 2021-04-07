<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
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

        $product_user = new Product();
        $product_user->name = "product1";
        $product_user->price_ht = 100;
        $product_user->description = "This is a description";
        $product_user->stock = 1;
        $product_user->user_id = $user1->id;
        $product_user->save();

        $product_user = new Product();
        $product_user->name = "product2";
        $product_user->price_ht = 400;
        $product_user->description = "This is a description";
        $product_user->stock = 1;
        $product_user->user_id = $user1->id;
        $product_user->save();

        $product_user = new Product();
        $product_user->name = "product3";
        $product_user->price_ht = 100.4;
        $product_user->description = "This is a description";
        $product_user->stock = 5;
        $product_user->user_id = $user2->id;
        $product_user->save();
    }
}
