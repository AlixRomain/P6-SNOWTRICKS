<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Form\TricksType;
use App\Repository\CategoryRepository;
use App\Repository\TricksRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TricksController extends AbstractController
{
    private $em;
    private $slugify;
    private $tricksRepo;

    function __construct( EntityManagerInterface $entityManager, TricksRepository $tricksRepo)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
        $this->tricksRepo = $tricksRepo;
    }
    /**
     * @Route("/snowtricks", name="home")
     * @param TricksRepository $tricksRepo
     * @return Response
     */
    public function index(TricksRepository $tricksRepo): Response
    {

       $tricks =  $this->tricksRepo->findBy([],['created_at'=> 'desc']);

        return $this->render('tricks/tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/snowtricks/{slug}", name="tricks_show")
     * @param                     $trick
     *
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function show(Tricks $trick, Request $request ): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setContent($form->get('content')->getData());
            $comment->setDateCreate(new \DateTime());
            $comment->setAuthor($this->getUser());
            $comment->setTricks($trick);
            $this->addFlash('success', 'Yes! Votre commentaire à bien été pris en compte.');
            $this->em->persist($comment);
            $this->em->flush();
        }

        return $this->render('tricks/show.html.twig', [
            'tricks' => $trick,
            'form'   => $form->createView()

        ]);
    }

    /**
     * @Route("/modifier-tricks/{slug}", name="tricks_update")
     * @param Tricks             $trick
     * @param Request            $request
     * @param CategoryRepository $repoCat
     *
     * @return Response
     * @Security(
     *      "user === trick.getAuthorId() || is_granted('ROLE_ADMIN')",
     *      message = "Vous n'avez pas les droits pour modifier ce tricks"
     * )
     * @IsGranted("ROLE_USER")
     *
     */
    public function update(Tricks $trick, Request $request, CategoryRepository $repoCat ): Response
    {
        $categorie = $repoCat->findAll();
        $slug = $trick->getSlug();
        $main_image = $trick->getMainImage();
        $form = $this->createForm(TricksType::class, $trick, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion en cas d'un slug identique déjà existant en base'*/
            $newSlug = $this->slugify->slugify(strtolower($trick->getName()));
            if($slug !== $newSlug){
                $slugExist = $this->tricksRepo->findOneBy(['slug' => $newSlug]);
                if($slugExist){
                    $this->addFlash('error', 'Désolé! Ce tricks est déjà existant en base, veuillez modifier votre titre.');
                    return $this->redirectToRoute('tricks_update', ['slug'=>$slug]);
                }else {
                    $trick->setSlug($this->slugify->slugify(strtolower($trick->getName())));
                }
            }
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('file')->getData();
            if(!is_null($main_file)){
                /*Change path before move file in media directory*/
                $trick->setPath($this->getParameter('img_main_directory').'/');
                $trick->setOldPath($main_image);
                $trick->setMainImage($main_file->getBasename());
            }

            /*Gestion de l'upload des images'*/
            foreach ($trick->getMedia() as $image) {
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
            foreach ($trick->getVideos() as $video){
                if($video->getpath() !== null) {
                    $video->setTricks($trick);
                    $video->setType('video');
                    $video->setName('Une video youtube partenaire de Snowtricks');
                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->getPath(), $matches);
                    $video->setPath($pathRootVideo . $matches[1]);
                }
            }

            $trick->setUpdateAt(new \Datetime);
            $this->em->flush();
            $this->addFlash('success', 'Yes! Votre tricks a bien été modifié!');
            return $this->redirectToRoute('user_tricks');

        }

        return $this->render('admin/admin_tricks/update.html.twig', [
            'tricks' => $trick,
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
        $tricks->setMainImage('default-image.jpg');
        $form = $this->createForm(TricksType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion en cas d'un slug identique déjà existant en base'*/
             $slugExist = $this->tricksRepo->findOneBy(['slug' => $this->slugify->slugify(strtolower($tricks->getName()))]);
             if($slugExist){
                 $this->addFlash('error', 'Désolé! Ce tricks est déjà existant en base, veuillez modifier votre titre.');
                 return $this->redirectToRoute('tricks_add');
             }else{
                 $tricks->setSlug($this->slugify->slugify(strtolower($tricks->getName())));
             }
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('file')->getData();
            if(!is_null($main_file) && ($tricks->getPath() !== 'default-image.jpg')){
                /*Change path before move file in media directory*/
                $tricks->setPath($this->getParameter('img_main_directory').'/');
                $tricks->setMainImage($main_file->getBasename());
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
            $this->em->persist($tricks);

            $this->em->flush();
            $this->addFlash('success', 'Yes! Votre tricks a bien été ajouté à la plateforme!');
            return $this->redirectToRoute('user_tricks');
        }
        return $this->render('admin/admin_tricks/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/supprimer-tricks/{slug}", name="tricks_delete")
     * @param                     $trick
     * @Security(
     *      "user === trick.getAuthorId() || is_granted('ROLE_ADMIN')",
     *      message = "Vous n'avez pas les droits pour supprimer ce tricks !"
     * )
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
        $this->addFlash('success', 'Yes! Le tricks a bien été supprimé de notre base de donnée.');
        return $this->redirectToRoute('user_tricks');
    }
    /**
     * Findall user tricks
     *
     * @Route("/profile/tricks", name="user_tricks")
     * @IsGranted( "ROLE_ADMIN")
     *
     * @return Response
     */
    public function findUserTricks(): Response
    {
        $tricks = $this->tricksRepo->findBy(['author_id' => $this->getUser()], ['created_at'=> 'desc']);

        return $this->render('admin/admin_tricks/all_user_tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * Find all tricks
     *
     * @Route("/admin/tricks", name="admin_tricks")
     *
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function findAllTricks(): Response
    {
        $tricks = $this->tricksRepo->findAll();
        return $this->render('admin/admin_tricks/all_tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

}
