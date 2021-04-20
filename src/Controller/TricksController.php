<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Form\TricksUpdateType;
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
    private $path_main;
    private $path_img;
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
     * @Route("/snowtricks/{id}", name="tricks_show")
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

            $this->em->persist($comment);
            $this->em->flush();
        }

        return $this->render('tricks/show.html.twig', [
            'tricks' => $trick,
            'form'   => $form->createView()

        ]);
    }
    /**
     * @Route("/modifier-tricks/{id}", name="tricks_update")
     * @param                     $trick
     * @Security(
     *      "user === trick.getAuthorId() || is_granted('ROLE_ADMIN')",
     *      message = "Vous n'avez pas les droits pour modifier ce tricks"
     * )
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function update(Tricks $trick, Request $request, CategoryRepository $repoCat ): Response
    {
        $categorie = $repoCat->findAll();
        $tricks = $this->em->getRepository(Tricks::class)->findOneById($trick->getId());
        $main_image = $tricks->getMainImage();
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('file')->getData();
            if(!is_null($main_file)){
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
            return $this->redirectToRoute('user_tricks');

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
        $tricks->setMainImage('default-image.jpg');
        $form = $this->createForm(TricksUpdateType::class, $tricks, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
            $tricks->setSlug($this->slugify->slugify(strtolower($tricks->getName())));
            $this->em->persist($tricks);

            $this->em->flush();
            $this->addFlash('success', 'Votre trick a été ajouté avec succés !');
            return $this->redirectToRoute('user_tricks');
        }
        return $this->render('tricks/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/supprimer-tricks/{id}", name="tricks_delete")
     * @param                     $trick
     * @Security(
     *      "user === tricks.getAuthorId() || is_granted('ROLE_ADMIN')",
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
        return $this->redirectToRoute('home');
    }
    /**
     * Findall user tricks
     *
     * @Route("/profile/tricks", name="user_tricks")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function findUserTricks(): Response
    {
        $tricks = $this->tricksRepo->findBy(['author_id' => $this->getUser()], ['created_at'=> 'desc']);

        return $this->render('admin/all_user_tricks.html.twig', [
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
        return $this->render('admin/all_tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

}
