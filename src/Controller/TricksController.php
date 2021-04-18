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
    private $path_main;
    private $path_img;

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
        $main_image = $tricks->getMainImage();
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('file')->getData();
            if($main_file !== null){
                /*Change path before move file in media directory*/
                $tricks->setPath($this->getParameter('img_main_directory').'/');
                $tricks->setOldPath($main_image);
                $tricks->setMainImage($main_file->getBasename());
            }

            /*Gestion de l'upload des images'*/
            foreach ($tricks->getMedia() as $image) {
                if( $image->getFile() !== null) {
                    $image->setType('img');
                    $image->setOldPath( $image->getName());
                    $image->setPath(substr($image->getFile(), 14, 26));
                    $image->setPathDirectory($this->getParameter('img_directory') . '/');
                    $image->setName($image->getPath());
                }
            }
            /*Gestion de l'upload des videos'*/
            $pathRootVideo = 'https://www.youtube.com/embed/';
            $goodPath = [];
            foreach ($tricks->getVideos() as $video){
                if($video->getpath() !== null) {
                    $video->setTricks($tricks);
                    $video->setType('video');
                    $video->setName('Une video youtube partenaire de Snowtricks');
                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->getPath(), $matches);
                    $video->setPath($pathRootVideo . $matches[1]);
                }
            }

            $tricks->setUpdateAt(new \Datetime);
            $this->em->flush();
            $this->addFlash('success', 'Votre trick a été modifié avec succés !');
            return $this->redirectToRoute('tricks_show', ['id' => $tricks->getId()]);

        }

        return $this->render('tricks/update.html.twig', [
            'tricks' => $tricks,
            'form'=>$form->createView(),
            'errors'=>$form->getErrors()
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
            $main_file = $form->get('file')->getData();
            if($main_file !== 'default-image'){
                /*Change path before move file in media directory*/
                $tricks->setPath($this->getParameter('img_main_directory').'/');
                $tricks->setMainImage($main_file->getBasename());
            }else{
                $tricks->setMainImage('default-image');
            }

            /*Gestion de l'upload des images'*/
            foreach ($tricks->getMedia() as $image) {
                $image->setType('img');
                $image->setPath(substr($image->getFile(), 14, 26));
                $image->setPathDirectory($this->getParameter('img_directory').'/');
                $image->setName($image->getPath());
            }

            /*Gestion de l'upload des videos'*/
            $pathRootVideo = 'https://www.youtube.com/embed/';
            $goodPath = [];
            foreach ($tricks->getVideos() as $video){
                $video->setTricks($tricks);
                $video->setType('video');
                $video->setName('Une video youtube partenaire de Snowtricks');
                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->getPath(), $matches);
                $video->setPath($pathRootVideo . $matches[1]);
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
     * @Route("/supprimer-tricks/{id}", name="tricks_delete")
     * @param                     $trick
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function delete(Tricks $trick): Response
    {
        $trick->setOldPath($trick->getMainImage());
        $trick->setPath($this->getParameter('img_main_directory').'/');
        foreach($trick->getMedia() as $img){
            $img->setPathDirectory($this->getParameter('img_directory').'/');
         }
        $this->em->remove($trick);
        $this->em->flush();
        return $this->redirectToRoute('home');
    }
}
