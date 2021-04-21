<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $em;
    private $slugify;
    private $userRepo;

    function __construct( EntityManagerInterface $entityManager, UserRepository $userRepo)
    {
        $this->em       = $entityManager;
        $this->slugify  = new Slugify();
        $this->userRepo = $userRepo;
    }

    /**
     * @Route("/modifier-profil/{id}", name="profil_user")
     * @param $user
     * @Security(
     *      "user === user",
     *      message = "Vous n'avez pas les droits pour modifier ce profil !"
     * )
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function updateUser(User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $user = $this->userRepo->findById($user->getId());
        return $this->render('admin/admin_user/udpate_user.html.twig', [
            'user' => $user,
            'form' => $form->createView()
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
        return $this->redirectToRoute('all_users_admin');
    }

}
