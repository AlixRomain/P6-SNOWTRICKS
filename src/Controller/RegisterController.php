<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Service\EmailService;
use Cocur\Slugify\Slugify;
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
    private $slug;

    function __construct( EntityManagerInterface $em, EmailService $emailService)
    {
        $this->em = $em;
        $this->slug = new Slugify();
        $this->emailService = $emailService;
    }


    /**
     * @Route("/inscription", name="register")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     * @throws \Exception
     */
    public function registerMethod(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /*check in base if new user exist*/
            $search_email = $this->em->getRepository((User::class))->findOneByEmail($user->getEmail());
            if(!$search_email){
                /*Set avatar and path directory*/
                $avatar_file = $form->get('file')->getData();
                if(!is_null($avatar_file)){
                    /*Change path before move file in media directory*/
                    $user->setPathDirectory($this->getParameter('avatar_directory').'/');
                    $user->setAvatar($avatar_file->getBasename());
                }
                /*Crypt the password with encoder*/
                $passwordEncoder = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($passwordEncoder);
                /*Programmation  delay of expiration Token and date Create*/
                $user->setDateCreate(new \DateTime);
                $user->setDateExpirToken(new \DateTime('+30 minutes'));
                /* Confirmation RGPD*/
                $user->setRgpd(1);
                 /* Initializatuin Token*/
                $user->setToken(md5(random_bytes(60)));
                $user->setSlug($this->slug->slugify(strtolower($user->getFname()."-".$user->getlname())));
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
