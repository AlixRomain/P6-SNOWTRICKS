<?php

namespace App\Service;

use PHPMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class EmailService
 * @package App\Service
 */
class EmailService extends AbstractController
{
    private $mail;
    public function __construct()
    {
        require_once('PHPMailer/class.phpmailer.php');
        require_once('../config/dataMail.php');
        $this->mail  = new PHPMailer();
    }

    /**
     * @param         $user
     * @param Request $request
     *
     * @return bool
     * @throws \phpmailerException
     */
    public function sendRegistrationEmail($user , Request $request){
        $body = $this->renderView('emails/registration.html.twig', [
            'name' => $user->getfname().' '.$user->getlname(),
            'link' => $request->server->get('SERVER_NAME').'/activation?id='.$user->getId().'&token='.$user->getToken()
        ]);
        $this->mail->SetFrom('inscription@snowtricks.com', 'Snowtricks');
        $this->mail->AddReplyTo("inscription@snowtricks.com","Snowtricks");
        $address = $user->getEmail();
        $this->mail->AddAddress($address, "John Doe");
        $this->mail->Subject    = "Confirmation de votre compte chez Snowtricks";
        $this->mail->IsSMTP(); // enable SMTP
        $this->mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $this->mail->SMTPAuth = true;  // authentication enabled
        $this->mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $this->mail->Host = MAIL_SMTP;
        $this->mail->Port = MAIL_PORT;
        $this->mail->Username = MAIL_USERNAME;
        $this->mail->Password = MAIL_PASSWORD;
        $this->mail->MsgHTML($body);

        if($this->mail->Send()){
            return  $this->addFlash('success','Un e-mail viens de vous être envoyé, vous avez à présent 30 minutes pour activer votre compte.');
        }
        return $this->addFlash('error','Oups ! Un problème est survenu lors de l\'envoie de votre email.');
    }

    /**
     * @param         $user
     * @param Request $request
     *
     * @return void
     * @throws \phpmailerException
     */
    public function sendForgetPassEmail($user , Request $request){
        $body = $this->renderView('emails/reset-password.html.twig', [
            'name' => $user->getfname().' '.$user->getlname(),
            'link' => $request->server->get('SERVER_NAME').'/reinitialisation-du-mot-de-passe?id='.$user->getId().'&token='.$user->getToken()
        ]);
        $this->mail->SetFrom('reset-password@snowtricks.com', 'Snowtricks');
        $this->mail->AddReplyTo("inscription@snowtricks.com","Snowtricks");
        $address = $user->getEmail();
        $this->mail->AddAddress($address, "Snowtricks");
        $this->mail->Subject    = "Modification de votre mot de passe de la plateforme Snowtricks";
        $this->mail->IsSMTP(); // enable SMTP
        $this->mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $this->mail->SMTPAuth = true;  // authentication enabled
        $this->mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $this->mail->Host = MAIL_SMTP;
        $this->mail->Port = MAIL_PORT;
        $this->mail->Username = MAIL_USERNAME;
        $this->mail->Password = MAIL_PASSWORD;
        $this->mail->MsgHTML($body);

        if($this->mail->Send()){
            return  $this->addFlash('success','Un e-mail viens de vous être envoyé, vous avez à présent 30 minutes pour réinitialiser votre mot de passe.');
        }
        return $this->addFlash('error','Oups ! Un problème est survenu lors de l\'envoie de votre email.');
    }
}
