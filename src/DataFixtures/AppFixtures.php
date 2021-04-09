<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TricksRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Serializer;

class AppFixtures extends Fixture
{
    private $repoCat;
    private $repoTricks;

    public function __construct(CategoryRepository $repoCat, TricksRepository $repoTricks)
    {
        $this->repoCat = $repoCat;
        $this->repoTricks = $repoTricks;

    }

    public function load(ObjectManager $manager)
    {
        /* Récupération du contenu du fichier .json */
        $contenu_fichier_json = file_get_contents(__DIR__.'/tricks.json');
        /* Les données sont récupérées sous forme de tableau (true) */
        $tr = json_decode($contenu_fichier_json, true);

        foreach ($tr["cat"] as $key){

            foreach ($key["types"] as $val){
                $categorie = new Category();
                $categorie->setName($val["name"]);
                $categorie->setDescription($val["description"]);
                $categorie->setCategoryParent($val["catParent"]);
                $manager->persist($categorie);
            }
        }
        $manager->flush();
    }
}
