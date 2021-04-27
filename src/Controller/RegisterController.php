<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\PasswordForgot;
use App\Entity\ResetPassWord;
use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\UploadMediaService;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
    private $repoUser;
    private $encoder;
    private $upluoadService;

    function __construct( EntityManagerInterface $em, EmailService $emailService, UserRepository $repoUser,UserPasswordEncoderInterface $encoder,UploadMediaService $upluoadService )
    {
        $this->em = $em;
        $this->slug = new Slugify();
        $this->emailService = $emailService;
        $this->repoUser = $repoUser;
        $this->encoder = $encoder;
        $this->upluoadService = $upluoadService;
    }


    /**
     * @Route("/inscription", name="register")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     * @throws \Exception
     */
    public function registerMethod(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /*check in base if new user exist*/
            $search_email = $this->em->getRepository((User::class))->findOneByEmail($user->getEmail());
            if(!$search_email){
                /*Set avatar and path directory*/
                $fileUpload = $form->get('file')->getData();
                $this->upluoadService->uploadMainImage($user, $fileUpload, $this->getParameter('avatar_directory'));
                /*Crypt the password with encoder*/
                $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
                /*Programmation  delay of expiration Token and date Create*/
                $user->setDateCreate(new \DateTime);
                $user->setDateExpirToken(new \DateTime('+30 minutes'));
                /* Confirmation RGPD*/
                $user->setRgpd(1);
                 /* Initialization Token*/
                $user->setToken(md5(random_bytes(60)));
                $user->setSlug($this->slug->slugify(strtolower($user->getFname()."-".$user->getlname())));
                $this->em->persist($user);
                $this->em->flush();

                if($this->emailService->sendRegistrationEmail($user, $request)){
                   return $this->redirectToRoute('home');
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
    /**
     * Email of activation
     *
     * @Route("/activation", name="account_confirm")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response
     *
     */
    public function confirm(Request $request): ?Response
    {
       $id      = $request->query->get('id');
       $token   = $request->query->get('token');
       if(!is_null($id)&&!is_null($token)){
           $userExist = $this->repoUser->findOneBy(['id' => $id, 'token' => $token]);
           if ($userExist) {
               $userExistIsValid = $this->repoUser->findOneUserByTokenValid($id);
               if($userExistIsValid){
                   $userExistIsValid->setActif(1);
                   $this->em->flush();
                   $this->addFlash('success', 'Votre compte est validé ! Vous pouvez des à présent vous connectez!');
                   return $this->redirectToRoute('app_login');
               }
               $this->addFlash('error', 'Temps écoulé ! Nous vous avons envoyé un nouveau lien d\'activation sur votre messagerie '.$userExist->getEmail().'!');
           }
           $this->addFlash('error', 'Oups rien à l\'horizon ! Il semblerait que ce lien ne mène à rien, veuillez vous rapprochez du masterWeb ');
       }
        return $this->redirectToRoute('app_login');
    }

    /**
     * Forgot password
     *
     * @Route("/mot-de-passe-oublier", name="password_forgot")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function forgotPassword( Request $request): Response
    {
        $PasswordForgot = new PasswordForgot();
        $form = $this->createForm(ForgetPasswordType::class, $PasswordForgot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->repoUser->findOneBy(['email' =>  $PasswordForgot->getEmail()]);
            if ($user) {
                /** @var User $user */
                $token = md5(random_bytes(60));
                $user->setToken($token);
                $user->setDateExpirToken(new \DateTime('+30 minutes'));
                $this->em->flush();
                if($this->emailService->sendForgetPassEmail($user, $request)){
                    return $this->redirectToRoute('app_login');
                }
            }else{
                $this->addFlash('error', 'Oups!, L\'email renseignée n\'existe pas en base.');
            }
            return $this->redirectToRoute('password_forgot');
        }
        return $this->render('register/forget-pass.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Build a new password after forgotPassword Method
     *
     * @Route("/reinitialisation-du-mot-de-passe", name="account_reset")
     *
     * @param Request $request
     * @param UserRepository $repo
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     *
     * @throws Exception
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $id      = $request->query->get('id');
        $token   = $request->query->get('token');
        $form = $this->createForm( ResetPasswordType::class);

        if(!is_null($id)&&!is_integer($id)&&!is_null($token)){
            $userExist = $this->repoUser->findOneBy(['id' => $id, 'token' => $token]);
            if ($userExist) {
                $userExistIsValid = $this->repoUser->findOneUserByTokenValid($id);
                if($userExistIsValid){
                    $passwordReset = new ResetPassWord();
                    $passwordReset->setEmail($userExistIsValid->getEmail());
                    $form = $this->createForm( ResetPasswordType::class, $passwordReset);
                }else{
                    $this->addFlash('error', 'Temps écoulé ! Désolé '.$userExist->getLname().' veuillez recommencer l\'opération pour obtenir un bouveau lien d\'activation!');
                }
            }else{
                $this->addFlash('error', 'Oups rien à l\'horizon ! Veuillez saisir dans l\url uniquement le lien fournit dans votre boîte mail');
            }
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            $user = $this->repoUser->findOneBy(['email' =>  $datas->getEmail()]);
            /*Crypt the password with encoder*/
            $user->setPassword($this->encoder->encodePassword($user, $datas->getPassword()));
            $this->em->flush();
            $this->redirectToRoute('app_login');
            $this->addFlash('success' , 'Veuillez vous connecter avec vos nouveaux identifiants');
            return $this->redirectToRoute('app_login');
        }


        return $this->render('Register/reset-pass.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
