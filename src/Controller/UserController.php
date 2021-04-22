<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\TricksRepository;
use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
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
     * @Route("/modifier-profil/{id}", name="profil_user")
     * @param User    $userLogin
     * @param Request $request
     *
     * @return Response
     * @Security(
     *      "user === user",
     *      message = "Vous n'avez pas les droits pour modifier ce profil !"
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateUser(User $userLogin, Request $request): Response
    {
       $stat = [];
        $oldMail = $this->getUser()->getUsername();
        $nbTricks = $this->tricksRepo->count(['author_id' => $userLogin->getId()]);
        $nbComments = $this->commentRepo->count(['author' => $userLogin->getId()]);
        $form = $this->createForm(UserType::class, $userLogin);
        $user = $this->userRepo->findById($userLogin->getId());
        array_push($stat, $nbTricks, $nbComments);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ($oldMail !== $userLogin->getEmail())? $reroute = 'app_logout': $reroute = 'home_admin';
            $this->em->flush();
            $this->addFlash('success', 'Yes! Votre profil utilisateur à bien été modifié en base de donnée.');
            return $this->redirectToRoute($reroute);
        }
        return $this->render('admin/admin_user/udpate_user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'stats' => $stat
        ]);
    }

    /**
     * @Route("/admin/tous-les-utilisateurs", name="all_users_admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function findAll(): Response
    {
        $user = $this->userRepo->findBy(['roles' => 'ROLE_USER']);
        return $this->render('admin/admin_user/all_users.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("/supprimer-utilisateur/{id}", name="user_delete")
     * @param                     $user
     * @IsGranted("ROLE_ADMIN")
     *
     * @return Response
     */
    public function delete(User $user): Response
    {
        if($user->getRoles() == 'ROLE_ADMIN' ){
            return $this->redirectToRoute('all_users_admin');
        }
        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash('success', 'Yes! Le profil utilisateur à bien été supprimé de notre base de donnée.');
        return $this->redirectToRoute('all_users_admin');
    }

}
