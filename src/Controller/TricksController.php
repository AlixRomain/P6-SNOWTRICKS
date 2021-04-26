<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Form\TricksType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\TricksRepository;
use App\Service\UploadMediaService;
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
    private $commentRepo;
    private $upluoadService;

    function __construct( EntityManagerInterface $entityManager, TricksRepository $tricksRepo, CommentRepository $commentRepo, UploadMediaService $upluoadService)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
        $this->tricksRepo = $tricksRepo;
        $this->commentRepo = $commentRepo;
        $this->upluoadService = $upluoadService;
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
        $comments = $this->commentRepo->findBy(['tricks' => $trick],['date_create'=>'desc']);
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
            return $this->redirectToRoute('tricks_show', ['slug' => $trick->getSlug() ]);
        }

        return $this->render('tricks/show.html.twig', [
            'tricks' => $trick,
            'form'   => $form->createView(),
            'comments'=> $comments

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
     *
     */
    public function update(Tricks $trick, Request $request, CategoryRepository $repoCat ): Response
    {
        $categorie = $repoCat->findAll();
        $slug = $trick->getSlug();
       /* $trick->setSlug('slug-par-defaut');*/
        $main_image = $trick->getMainImage();
        $form = $this->createForm(TricksType::class, $trick, array('categorie'=> $categorie));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
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
            $this->upluoadService->uploadMainImage($trick, $main_file,$this->getParameter('img_main_directory'),$main_image);
            /*Gestion de l'upload des images'*/
            $this->upluoadService->uploadImageMethod($trick, $this->getParameter('img_directory'));
            /*Gestion de l'upload des video'*/
            $this->upluoadService->uploadVideoMethod($trick);
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
        $trick = new Tricks();
        $trick->setMainImage('default-image.jpg');
        $form = $this->createForm(TricksType::class, $trick, array('categorie'=> $categorie));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*Gestion en cas d'un slug identique déjà existant en base'*/
             $slugExist = $this->tricksRepo->findOneBy(['slug' => $this->slugify->slugify(strtolower($trick->getName()))]);
             if($slugExist){
                 $this->addFlash('error', 'Désolé! Ce tricks est déjà existant en base, veuillez modifier votre titre.');
                 return $this->redirectToRoute('tricks_add');
             }else{
                 $trick->setSlug($this->slugify->slugify(strtolower($trick->getName())));
             }
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $main_file = $form->get('file')->getData();
            $this->upluoadService->uploadMainImage($trick, $main_file,$this->getParameter('img_main_directory'));
            /*Gestion de l'upload des images'*/
            $this->upluoadService->uploadImageMethod($trick, $this->getParameter('img_directory'));
            /*Gestion de l'upload des video'*/
            $this->upluoadService->uploadVideoMethod($trick);
            /*Hydration of tricks with form data*/
            $trick->setAuthorId($this->getUser());
            $trick->setCreatedAt(new \DateTime());
            $this->em->persist($trick);

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
     * @IsGranted( "ROLE_USER")
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
