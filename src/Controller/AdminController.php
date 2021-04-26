<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\TricksRepository;
use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $em;
    private $slugify;
    private $userRepo;
    private $commentRepo;
    private $tricksRepo;

    function __construct( EntityManagerInterface $entityManager, UserRepository $userRepo, CommentRepository $commentRepo,TricksRepository $tricksRepo)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
        $this->userRepo = $userRepo;
        $this->commentRepo = $commentRepo;
        $this->tricksRepo = $tricksRepo;
    }
    /**
     * @Route("/profile/admin-dashboard", name="home_admin")
     * @IsGranted("ROLE_USER")
     */
    public function dashboard(): Response
    {
        $stats = [];
        $nbTricks = $this->tricksRepo->count(['author_id' => $this->getUser()->getId()]);
        $nbComments = $this->commentRepo->count(['author' => $this->getUser()->getId()]);
        array_push($stats, $nbTricks, $nbComments);
        $tricks = $this->tricksRepo->findBy(['author_id' => $this->getUser()->getId()], [],2);
        $comments = $this->commentRepo->findBy(['author' => $this->getUser()->getId()] ,[],2);
        return $this->render('admin/dashboard.html.twig', [
            'tricks' => $tricks,
            'comments' => $comments,
            'stats' => $stats
        ]);
    }
}
