<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $em;
    private $emailService;

    function __construct( EntityManagerInterface $em, EmailService $emailService)
    {
        $this->em = $em;
        $this->emailService = $emailService;
    }


    /**
     * @Route("/inscription", name="register")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function registerMethod(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $date = new \DateTime();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /*check in base if new user exist*/
            $search_email = $this->em->getRepository((User::class))->findOneByEmail($user->getEmail());
            if(!$search_email){
                /*Crypt the password with encodeer*/
                $passwordEncoder = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($passwordEncoder);
                /*Programmation  delay of expiration Token*/
                $date->setTimestamp(strtotime("+30 minutes"));
                $date_token	= $date->format('Y-m-d H:i:s');
                $user->setDateExpirToken($date_token);
                $this->em->persist($user);
                $this->em->flush();

                if($this->emailService->sendRegistrationEmail($user, $request)){
                    $this->redirectToRoute('app_login');
                };
                $this->redirectToRoute('register');
            }else{
                $this->addFlash('error','L\'email renseignée existe déjà en base.');
            }
        }

        return $this->render('Register/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
