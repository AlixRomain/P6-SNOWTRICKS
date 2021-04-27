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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UploadMediaService;

class UserController extends AbstractController
{
    private $em;
    private $slugify;
    private $userRepo;
    private $commentRepo;
    private $tricksRepo;
    private $upluoadService;

    function __construct( EntityManagerInterface $entityManager, UserRepository $userRepo, CommentRepository $commentRepo,TricksRepository $tricksRepo, UploadMediaService $upluoadService)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
        $this->userRepo = $userRepo;
        $this->commentRepo = $commentRepo;
        $this->tricksRepo = $tricksRepo;
        $this->upluoadService = $upluoadService;
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
     * @IsGranted("ROLE_USER")
     */
    public function updateUser(User $userLogin, Request $request): Response
    {
        $oldMail = $this->getUser()->getUsername();
        $nbTricks = $this->tricksRepo->count(['author_id' => $userLogin->getId()]);
        $nbComments = $this->commentRepo->count(['author' => $userLogin->getId()]);
        $avatar = $userLogin->getAvatar();
        $form = $this->createForm(UserType::class, $userLogin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            PROUT PROUT PROUT
            P
            /*Gestion de l'upload du main_image' dans la table tricks*/
            $fileUpload = $form->get('file')->getData();
            $this->upluoadService->uploadMainImage($userLogin, $fileUpload, $this->getParameter('avatar_directory'), $avatar);

            ($oldMail !== $userLogin->getEmail())? $reroute = 'app_logout': $reroute = 'home_admin';
            $this->em->flush();
            $this->addFlash('success', 'Yes! Votre profil utilisateur à bien été modifié en base de donnée.');
            /*Dont touch*/
            $userLogin->setFile(null);
            return $this->redirectToRoute($reroute);
        }

        return $this->render('admin/admin_user/udpate_user.html.twig', [
            'user' => $userLogin,
            'form' => $form->createView(),
            'stats' => array_merge($nbTricks, $nbComments)
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
     * @param User $user
     *
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     *
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
