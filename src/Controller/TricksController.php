<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Tricks;
use App\Form\TricksUpdateType;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use App\Repository\TricksRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use mysql_xdevapi\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

class TricksController extends AbstractController
{
    private $em;
    private $slugify;


    function __construct( EntityManagerInterface $entityManager)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
    }
    /**
     * @Route("/snowtricks", name="home")
     * @param TricksRepository $tricksRepo
     * @return Response
     */
    public function index(TricksRepository $tricksRepo): Response
    {

        $tricks = $tricksRepo->findAll();

        return $this->render('tricks/tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/snowtricks/{id}", name="tricks_show")
     * @param                     $id
     *
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function show($id, Request $request ): Response
    {
        $tricks = $this->em->getRepository(Tricks::class)->findOneById($id);


        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'form'=>'rien'

        ]);
    }
    /**
     * @Route("/modifier-tricks/{id}", name="tricks_update")
     * @param                     $id
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function update($id, Request $request, CategoryRepository $repoCat, MediaRepository $repoMedia ): Response
    {
        $categorie = $repoCat->findAll();
        $tricks = $this->em->getRepository(Tricks::class)->findOneById($id);
        $images = $repoMedia->findBy(array('tricks' => $tricks->getId()));
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('main_image')->getData();
            if(isset($main_file)){
                /*Change path before move file in media directory*/
                $newPath = 'asset/media/main/'.$main_file->getBasename();
                $tricks->setMainImage($newPath);
                try {
                    $main_file->move(
                        $this->getParameter('img_main_directory'),
                        $newPath
                    );
                    throw new FileException( 'Echec lors du déplacement du fichier.' );
                } catch (FileException $e) {

                    $this->addFlash('success', '$e->getMessage()');
                }
            }

            /*Gestion de l'upload des images'*/
            foreach ($tricks->getMedia() as $image) {
                if(!is_null( $image->getPath())){

                    $oldPath = $image->getPath();
                    $newPath = 'asset/media/img/' . substr($image->getPath(), -11, 11);
                    $image->setType('img');
                    $image->setPath($newPath);
                    $image->setName('Tricks de snowtricks ');
                    /*Déplacement des images dans fichier media'*/
                    move_uploaded_file( $oldPath, $this->getParameter('kernel.project_dir').'/public/'. $newPath);
                }
            }
            $tricks->setUpdateAt(new \Datetime);
            $this->em->flush();
            $this->addFlash('success', 'Votre trick a été modifié avec succés !');
            return $this->redirectToRoute('tricks_show', ['id' => $tricks->getId()]);

        }
        return $this->render('tricks/update.html.twig', [
            'tricks' => $tricks,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/ajouter-tricks", name="tricks_add")
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function add( Request $request, CategoryRepository $repoCat ): Response
    {
        $categorie = $repoCat->findAll();
        $tricks = new Tricks();
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('main_image')->getData();
            if(isset($main_file)){
                /*Change path before move file in media directory*/
                $newPath = 'asset/media/main/'.$main_file->getBasename();
                $tricks->setMainImage($newPath);
                try {
                    $main_file->move(
                        $this->getParameter('img_main_directory'),
                        $newPath
                    );
                    throw new FileException( 'Echec lors du déplacement du fichier.' );
                } catch (FileException $e) {

                    $this->addFlash('success', '$e->getMessage()');
                }
            }

            /*Gestion de l'upload des images'*/
            foreach ($tricks->getMedia() as $image) {
                $oldPath = $image->getPath();
                $newPath = 'asset/media/img/' . substr($image->getPath(), -11, 11);
                $image->setType('img');
                $image->setPath($newPath);
                $image->setName('Tricks de snowtricks ');
                /*Déplacement des images dans fichier media'*/
                move_uploaded_file( $oldPath, $this->getParameter('kernel.project_dir').'/public/'. $newPath);
            }

            /*Gestion de l'upload des videos'*/
            $pathRootVideo = 'https://www.youtube.com/embed/';
            $goodPath = [];
            foreach ($tricks->getVideos() as $video){
                $video->setTricks($tricks);
                $video->setType('video');
                $video->setName('Une video youtube partenaire de Snowtricks');
                parse_str( parse_url( $video->getPath(), PHP_URL_QUERY ), $goodPath );
                $video->setPath($pathRootVideo.$goodPath['v']);
            }
            /*Hydration of tricks with form data*/
            $tricks->setAuthorId($this->getUser());
            $tricks->setCreatedAt(new \DateTime());
            $tricks->setSlug($this->slugify->slugify(strtolower($tricks->getName())));
            $this->em->persist($tricks);
            $this->em->flush();
            $this->addFlash('success', 'Votre trick a été ajouté avec succés !');
            return $this->redirectToRoute('home');
        }
        return $this->render('tricks/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/snowtricks/{id}", name="tricks_delete")
     * @param                     $id
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function delete($id, Request $request ): Response
    {
        $tricks = $this->em->getRepository(Tricks::class)->findOneBySlug($id);


        return $this->render('tricks/show.html.twig', [
            'tricks' => $tricks,
            'pagination'=>'rien'
        ]);
    }
}
