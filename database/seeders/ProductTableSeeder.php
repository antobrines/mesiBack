<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
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

        $category1 = Category::where('name', 'Vêtements')->first();
        $category2 = Category::where('name', 'Mobilier')->first();
        $category3 = Category::where('name', 'Bijoux')->first();
        $user1 = User::where('email', 'admin@dev.fr')->first();
        $user2 = User::where('email', 'user@dev.fr')->first();

        $product_user = new Product();
        $product_user->name = "Table bois";
        $product_user->price_ht = 100;
        $product_user->description = "This is a description";
        $product_user->stock = 1;
        $product_user->user_id = $user1->id;
        $product_user->product_image = "https://www.so-inside.com/11819-large_default/table-de-salle-a-manger-ronde-avec-pietement-en-bois-massif-et-plateau-plaque-chene-naturel-racoon.jpg";
        $product_user->save();
        $product_user->categories()->attach($category1);
        $product_user->categories()->attach($category2);

        $product_user = new Product();
        $product_user->name = "Chaise";
        $product_user->price_ht = 400;
        $product_user->description = "This is a description";
        $product_user->stock = 1;
        $product_user->user_id = $user1->id;
        $product_user->product_image = "https://cdn.habitat.fr/thumbnails/product/1112/1112877/box/850/850/40/F4F4F4/chaise-en-chene-massif-bois-clair_1112877.jpg";
        $product_user->save();
        $product_user->categories()->attach($category3);

        $product_user = new Product();
        $product_user->name = "Console";
        $product_user->price_ht = 100.4;
        $product_user->description = "This is a description";
        $product_user->stock = 5;
        $product_user->user_id = $user2->id;
        $product_user->product_image = "https://www.atmosphera.com/phototheque/atmosphera.com/12500/large/01W012410A.jpg";
        $product_user->save();
        $product_user->categories()->attach($category2);
    }
}
