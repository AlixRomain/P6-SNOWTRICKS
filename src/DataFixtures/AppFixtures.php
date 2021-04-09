<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Tricks;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\TricksRepository;
use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $repoCat;
    private $repoTricks;
    private $faker;
    private $passwordEncoder;
    private $repoUser;
    private $slug;

    public function __construct(UserRepository $repoUser, CategoryRepository $repoCat, TricksRepository $repoTricks, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repoCat = $repoCat;
        $this->repoUser = $repoUser;
        $this->repoTricks = $repoTricks;
        $this->faker = Factory::create("fr_FR");
        $this->passwordEncoder = $passwordEncoder;
        $this->slug =  new Slugify();
    }

    public function load(ObjectManager $manager)
    {
        //FOR LOAD METHOD WITH DROP TABLE "symfony console doctrine:fixtures:load"
        //FOR LOAD METHOD WITHOUT DROP TABLE "symfony console doctrine:fixtures:load --append"
        //METHOD FOR INSERT CATEGORY

        //Remplissage de la table categorie
         $contenu_fichier_json = file_get_contents(__DIR__.'/tricks.json');
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
        //Création de 20 adhérents
        $roleUser[]= USER::ROLE_USER;
        for($i = 0; $i<20; $i++){
            $adherent = new User();
            $adherent   ->setLname($this->faker->lastName)
                ->setFname($this->faker->firstName($genre=mt_rand(0,1)))
                ->setRoles($roleUser)
                ->setRgpd(1)
                ->setAvatar('asset/media/avatar/profil_'.$this->faker->numberBetween(1,20).'.jpg')
                ->setDateCreate($this->faker->dateTimeInInterval( '-2 years', 'now'))
                ->setDevise('Mr '.$adherent->getFname().' pour vous servir !')
                ->setSlug($this->slug->slugify(strtolower($adherent->getFname().$adherent->getLname())))
                ->setEmail($adherent->getFname().'-'.$adherent->getlname().'@snowtrick.com')
                ->setPassword($this->passwordEncoder->encodePassword($adherent,$adherent->getFname()));
            //La méthode permet d'attribuer une ckef/réference à chaque valeur/objet.
            //// Une sorte de tableau d'association connu gere par faker
            /// "adherentX" est associé à l'objet $adherentX
            $this->addReference("adherent".$i, $adherent);
            $manager->persist($adherent);

            //Création de 20 tricks associé à un adhérent
                $allCategorie = $this->repoCat->findAll();
                $author = $this->faker->numberBetween(1,20);
                $trick = new Tricks();
                $trick ->setAuthorId( $adherent)
                    ->setName( $this->faker->sentence(2))
                    ->setMainImage('asset/media/main/snow_'.$this->faker->numberBetween(1,22).'.jpg')
                    ->setCreatedAt($this->faker->dateTimeInInterval( '-2 years', 'now'))
                    ->setSlug($this->slug->slugify(strtolower($trick->getName())))
                    ->addCategory($allCategorie[$this->faker->numberBetween(0,19)])
                    ->setDescription($this->faker->realText(200));
                $this->addReference("tricks".$i, $trick);
                $manager->persist($trick);

            //Association
        }
                 $adherentAdmin = new User();
                 $roleAdmin[]= USER::ROLE_ADMIN;
                 $adherentAdmin      ->setLname("Alix")
                  ->setFname("Romain")
                  ->setEmail("toto@toto.com")
                  ->setPassword($this->passwordEncoder->encodePassword($adherentAdmin,'toto'))
                  ->setRgpd(1)
                  ->setRoles($roleAdmin)
                  ->setAvatar('profil_'.$this->faker->numberBetween(1,20).'jpg')
                  ->setDateCreate($this->faker->dateTimeInInterval( '-2 years', 'now'))
                  ->setDevise('Née pour coder')
                  ->setSlug($this->slug->slugify(strtolower($adherentAdmin->getFname().$adherentAdmin->getLname())));
              $manager->persist($adherentAdmin);

              $manager->flush();
    }
}

