<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product1 = Product::where('id', 1)->first();
        $product2 = Product::where('id', 2)->first();
        $product3 = Product::where('id', 3)->first();

        $image_product = new Image();
        $image_product->image_url = 'https://s1.qwant.com/thumbr/0x380/b/e/a8acbb8e97f6606f412276ae4724975a56bf4b93de8ab333fe13ce71ce7f06/bureau-individuel-reglable-en-hauteur-yan-mdd-mdd.jpg?u=https%3A%2F%2Fbureau-store.fr%2F5703%2Fbureau-individuel-reglable-en-hauteur-yan-mdd-mdd.jpg&q=0&b=1&p=0&a=0';
        $image_product->image_name = "bureau";
        $image_product->product_id = $product1->id;
        $image_product->save();

        $image_product = new Image();
        $image_product->image_url = 'https://s2.qwant.com/thumbr/0x380/f/f/7b06bc753f1a76a3e61132f8df6695fa9f219658a262753db349746b2a9c00/chaise-grise-style-scandinave-spak-lot-de-2-57850.jpg?u=https%3A%2F%2Fwww.lestendances.fr%2FImages%2Fproduits%2Fchaise-grise-style-scandinave-spak-lot-de-2-57850.jpg&q=0&b=1&p=0&a=0';
        $image_product->image_name = "chaises";
        $image_product->product_id = $product2->id;
        $image_product->save();

        $image_product = new Image();
        $image_product->image_url = 'https://s2.qwant.com/thumbr/0x380/f/e/26e54cf8042858e8aa2ccb269c465dd4f5d72e28984504e527a116fc247d71/grand-tableau-colore-peinture-multicolore.jpg?u=https%3A%2F%2Fwww.amesauvage.com%2F1287-3689-thickbox_default%2Fgrand-tableau-colore-peinture-multicolore.jpg&q=0&b=1&p=0&a=0';
        $image_product->image_name = "tableau";
        $image_product->product_id = $product3->id;
        $image_product->save();

        $image_product = new Image();
        $image_product->image_url = 'https://s1.qwant.com/thumbr/0x380/b/e/a8acbb8e97f6606f412276ae4724975a56bf4b93de8ab333fe13ce71ce7f06/bureau-individuel-reglable-en-hauteur-yan-mdd-mdd.jpg?u=https%3A%2F%2Fbureau-store.fr%2F5703%2Fbureau-individuel-reglable-en-hauteur-yan-mdd-mdd.jpg&q=0&b=1&p=0&a=0';
        $image_product->image_name = "bureau";
        $image_product->product_id = $product1->id;
        $image_product->save();

        $image_product = new Image();
        $image_product->image_url = 'https://s2.qwant.com/thumbr/0x380/f/f/7b06bc753f1a76a3e61132f8df6695fa9f219658a262753db349746b2a9c00/chaise-grise-style-scandinave-spak-lot-de-2-57850.jpg?u=https%3A%2F%2Fwww.lestendances.fr%2FImages%2Fproduits%2Fchaise-grise-style-scandinave-spak-lot-de-2-57850.jpg&q=0&b=1&p=0&a=0';
        $image_product->image_name = "chaises";
        $image_product->product_id = $product2->id;
        $image_product->save();

        $image_product = new Image();
        $image_product->image_url = 'https://s2.qwant.com/thumbr/0x380/f/e/26e54cf8042858e8aa2ccb269c465dd4f5d72e28984504e527a116fc247d71/grand-tableau-colore-peinture-multicolore.jpg?u=https%3A%2F%2Fwww.amesauvage.com%2F1287-3689-thickbox_default%2Fgrand-tableau-colore-peinture-multicolore.jpg&q=0&b=1&p=0&a=0';
        $image_product->image_name = "tableau";
        $image_product->product_id = $product3->id;
        $image_product->save();
    }
}
