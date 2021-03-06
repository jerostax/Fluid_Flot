<?php

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
        //Création de 1 produit à partir de la factory
        factory(App\Product::class, 1)->create()->each(function($product){

            //Ajout des images
            $link = str_random(12).'.jpg'; // hash de lien pour la sécurité (injection de scripts de protection)
            $file = file_get_contents('http://placeimg.com/640/480/arch'); 
            Storage::disk('local')->put($link, $file);

            $product->pictureProduct()->create([
                'titre' => 'Default', 
                'url_img_products' => $link
            ]);
            $product->save(); 
        });
    }
}
