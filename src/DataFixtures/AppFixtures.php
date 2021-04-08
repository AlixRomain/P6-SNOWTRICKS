<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Serializer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /* Récupération du contenu du fichier .json */
        $contenu_fichier_json = file_get_contents(__DIR__.'/tricks.json');
        /* Les données sont récupérées sous forme de tableau (true) */
        $tr = json_decode($contenu_fichier_json, true);
        foreach ($tr["cat"] as $key){
            foreach ($key["types"] as $val){
                dump($val["name"]);
            }

        }
        foreach ($tr["cat"][1]["types"] as $val){

            dump($val["name"]);
        }

        dd();
        $manager->flush();
    }
}
