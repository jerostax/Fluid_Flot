<?php

use Illuminate\Database\Seeder;

class PartnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Création de 1 partenairs à partir de la factory
        factory(App\Partner::class, 1)->create()->each(function($partner){

            //Ajout des images
            $link = str_random(12).'.jpg'; // hash de lien pour la sécurité (injection de scripts de protection)
            $file = file_get_contents('http://placeimg.com/640/480/arch'); 
            Storage::disk('local')->put($link, $file);

            $partner->picturePartner()->create([
                'titre' => 'Default', 
                'url_img_partners' => $link
            ]);
            $partner->save(); 
        });
    }
}
