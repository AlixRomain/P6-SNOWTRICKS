<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $em;
    private $userRepo;

    function __construct( EntityManagerInterface $entityManager, UserRepository $userRepo)
    {
        $this->em       = $entityManager;
        $this->userRepo = $userRepo;
    }
    /**
     * @Route("/modification-du-mot-de-passe", name="account_password")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            #je recupere l'ancsien password
            $old_password = $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user, $old_password)){
                $new_password = $form->get('new_password')->getData();
                $passwordEncoder = $encoder->encodePassword($user, $new_password);
                $user->setPassword($passwordEncoder);
                $this->em->flush();
                $this->addFlash('success', 'Yes! Votre changement de mot de passe à bien été pri en compte.');
            }else{
                $this->addFlash('error', 'Oups! Le mot de passe actuel ne correspond pas avec celui inséré en base.');
            }
        }


        return $this->render('admin/admin_user/udpate_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
